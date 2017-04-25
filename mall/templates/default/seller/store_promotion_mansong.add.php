<?php defined('ByFeiWa') or exit('Access Invalid!');?>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div class="alert alert-block mt10">
  <ul class="mt5">
    <li>1、该插件模块为商业版专用，如有需要可前往官方下载</li>
    <li>2、插件下载地址<a href="http://www.feiwa.org/thread-10-1-1.html" target="_blank">http://www.feiwa.org/thread-10-1-1.html</a></li>
    <li>2、查看功能演示可前往官方演示站<a href="http://www.demo.feiwa.org/" target="_blank">http://www.demo.feiwa.org/</a></li>
  </ul>
</div>
<script id="mansong_rule_template" type="text/html">
<li nctype="mansong_rule_item">
<span>单笔订单满<strong><%=price%></strong>元， </span>
<span>立减现金<strong><%=discount%></strong>元， </span>
<%if(goods_id>0){%>
<span>送礼品 <%==goods%></span>
<%}%>
<input type="hidden" name="mansong_rule[]" value="<%=price%>,<%=discount%>,<%=goods_id%>">
<a nctype="btn_del_mansong_rule" href="javascript:void(0);" class="ncbtn-mini ncbtn-grapefruit"><i class="icon-trash"></i>删除</a>
</li>
</script>
<script id="mansong_goods_template" type="text/html">
    <div nctype="mansong_goods" class="selected-mansong-goods">
    <a href="<%=goods_url%>" title="<%=goods_name%>" class="goods-thumb" target="_blank">
        <img src="<%=goods_image_url%>"/>
    </a>
    <input nctype="mansong_goods_id" type="hidden" value="<%=goods_id%>">
    </div><a nctype="btn_del_mansong_goods" href="javascript:void(0);" class="ncbtn-mini ncbtn-grapefruit"><i class="icon-trash"></i>删除已选择的礼品</a>
</script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/common.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/template.min.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui-timepicker-addon/jquery-ui-timepicker-addon.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui-timepicker-addon/jquery-ui-timepicker-addon.min.css"  />
<script type="text/javascript">
$(document).ready(function(){
    $('#start_time').datetimepicker({
        controlType: 'select'
    });
    $('#end_time').datetimepicker({
        controlType: 'select'
    });

    jQuery.validator.methods.greaterThanDate = function(value, element, param) {
        var date1 = new Date(Date.parse(param.replace(/-/g, "/")));
        var date2 = new Date(Date.parse(value.replace(/-/g, "/")));
        return date1 < date2;
    };
    jQuery.validator.methods.lessThanDate = function(value, element, param) {
        var date1 = new Date(Date.parse(param.replace(/-/g, "/")));
        var date2 = new Date(Date.parse(value.replace(/-/g, "/")));
        return date1 > date2;
    };
    jQuery.validator.methods.greaterThanStartDate = function(value, element) {
        var start_date = $("#start_time").val();
        var date1 = new Date(Date.parse(start_date.replace(/-/g, "/")));
        var date2 = new Date(Date.parse(value.replace(/-/g, "/")));
        return date1 < date2;
    };

    //页面输入内容验证
    $("#add_form").validate({
        errorPlacement: function(error, element){
            var error_td = element.parent('dd').children('span.error-message');
            error_td.append(error);
        },
        onfocusout: false,
        submitHandler:function(form){
            ajaxpost('add_form', '', '', 'onerror');
        },
        rules : {
            mansong_name : {
                required : true
            },
            start_time : {
                required : true,
                greaterThanDate : '<?php echo date('Y-m-d H:i',$output['start_time']);?>'
            },
            end_time : {
                required : true,
<?php if (!$output['isOwnMall']) { ?>
                lessThanDate : '<?php echo date('Y-m-d H:i',$output['end_time']);?>',
<?php } ?>
                greaterThanStartDate : true
            },
            rule_count: {
                required: true,
                min: 1
            }
        },
        messages : {
            mansong_name : {
                required : '<i class="icon-exclamation-sign"></i><?php echo $lang['mansong_name_error'];?>'
            },
            start_time : {
                required : '<i class="icon-exclamation-sign"></i><?php echo sprintf($lang['mansong_add_start_time_explain'],date('Y-m-d H:i',$output['start_time']));?>',
                greaterThanDate : '<i class="icon-exclamation-sign"></i><?php echo sprintf($lang['mansong_add_start_time_explain'],date('Y-m-d H:i',$output['start_time']));?>'
            },
            end_time : {
                required : '<i class="icon-exclamation-sign"></i><?php echo sprintf($lang['mansong_add_end_time_explain'],date('Y-m-d H:i',$output['end_time']));?>',
<?php if (!$output['isOwnMall']) { ?>
                lessThanDate : '<i class="icon-exclamation-sign"></i><?php echo sprintf($lang['mansong_add_end_time_explain'],date('Y-m-d H:i',$output['end_time']));?>',
<?php } ?>
                greaterThanStartDate : '<i class="icon-exclamation-sign"></i><?php echo $lang['greater_than_start_time'];?>'
            },
            rule_count: {
                required: '<i class="icon-exclamation-sign"></i>请至少添加一条规则并确定',
                min: '<i class="icon-exclamation-sign"></i>请至少添加一条规则并确定'
            }
        }
    });

    // 限时添加规则窗口
    $('#btn_add_rule').on('click', function() {
        $('#mansong_price').val('');
        $('#mansong_discount').val('');
        $('#mansong_goods_item').html('');
        $('#mansong_price_error').hide();
        $('#mansong_rule_error').hide();
        $('#div_add_rule').show();
        $('#btn_add_rule').hide();
    });

    // 规则保存
    $('#btn_save_rule').on('click', function() {
        var mansong = {};
        mansong.price = Number($('#mansong_price').val());
        if(isNaN(mansong.price) || mansong.price <= 0) {
            $('#mansong_price_error').show();
            return false;
        } else {
            $('#mansong_price_error').hide();
        }
        mansong.discount = Number($('#mansong_discount').val());
        if(isNaN(mansong.discount) || mansong.discount < 0 || mansong.discount > mansong.price) {
            $('#mansong_discount_error').show();
            return false;
        } else {
            $('#mansong_discount_error').hide();
        }
        mansong.goods = $('#mansong_goods_item').find('[nctype="mansong_goods"]').html();
        mansong.goods_id = Number($('#mansong_goods_item').find('[nctype="mansong_goods_id"]').val());
        if(isNaN(mansong.goods_id)) {
            mansong.goods_id = 0;
        }
        if(mansong.discount == 0 && mansong.goods_id == 0) {
            $('#mansong_rule_error').show();
            return false;
        } else {
            $('#mansong_rule_error').hide();
        }
        var mansong_rule_item = template.render('mansong_rule_template', mansong);
        $('#mansong_rule_list').append(mansong_rule_item);
        close_div_add_rule();
    });

    // 删除已添加的规则
    $('#mansong_rule_list').on('click', '[nctype="btn_del_mansong_rule"]', function() {
        $(this).parents('[nctype="mansong_rule_item"]').remove();
        close_div_add_rule();
    });

    // 取消添加规则
    $('#btn_cancel_add_rule').on('click', function() {
        close_div_add_rule();
    });

    // 关闭规则添加窗口
    function close_div_add_rule() {
        var rule_count = $('#mansong_rule_list').find('[nctype="mansong_rule_item"]').length;
        if( rule_count >= 3) {
            $('#btn_add_rule').hide();
        } else {
            $('#btn_add_rule').show();
        }
        $('#div_add_rule').hide();
        $('#mansong_rule_count').val(rule_count);
    }

    // 限时商品选择窗口
    $('#btn_show_search_goods').on('click', function() {
        $('#div_search_goods').show();
    });

    // 搜索商品
    $('#btn_search_goods').on('click', function() {
        var url = "<?php echo urlMall('store_promotion_mansong', 'search_goods');?>";
        url += '&' + $.param({goods_name: $('#search_goods_name').val()});
        $('#div_goods_search_result').load(url);
    });

    // 搜索商品翻页
    $('#div_goods_search_result').on('click', 'a.demo', function() {
        $('#div_goods_search_result').load($(this).attr('href'));
        return false;
    });

    // 关闭商品选择窗口
    $('#btn_hide_search_goods').on('click', function() {
        $('#div_search_goods').hide();
    });

    // 选择商品
    $('#div_goods_search_result').on('click', '[nctype="btn_add_mansong_goods"]', function() {
        var goods = {};
        goods.goods_id = $(this).attr('data-goods-id');
        goods.goods_name = $(this).attr('data-goods-name');
        goods.goods_image_url = $(this).attr('data-goods-image-url');
        goods.goods_url = $(this).attr('data-goods-url');
        var mansong_goods_item = template.render('mansong_goods_template', goods);
        $('#mansong_goods_item').html(mansong_goods_item);
        $('#div_search_goods').hide();
    });

    // 删除以选的商品
    $('#mansong_goods_item').on('click', '[nctype="btn_del_mansong_goods"]', function() {
        $('#mansong_goods_item').html('');
    });

});
</script>
