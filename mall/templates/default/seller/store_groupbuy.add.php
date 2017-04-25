<?php defined('ByFeiWa') or exit('Access Invalid!');?>
<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div class="alert alert-block mt10">
  <ul class="mt5">
    <li>1、该插件模块为商业版专用，如有需要可前往官方下载</li>
    <li>2、插件下载地址<a href="http://www.feiwa.org/thread-8-1-1.html" target="_blank">http://www.feiwa.org/thread-8-1-1.html</a></li>
    <li>2、查看功能演示可前往官方演示站<a href="http://www.demo.feiwa.org/" target="_blank">http://www.demo.feiwa.org/</a></li>
  </ul>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui-timepicker-addon/jquery-ui-timepicker-addon.min.css"  />
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.ajaxContent.pack.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui-timepicker-addon/jquery-ui-timepicker-addon.min.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.iframe-transport.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.ui.widget.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.fileupload.js" charset="utf-8"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#start_time').datetimepicker({
        controlType: 'select'
    });

    $('#end_time').datetimepicker({
        controlType: 'select'
    });

    $('#btn_show_search_goods').on('click', function() {
        $('#div_search_goods').show();
    });

    $('#btn_hide_search_goods').on('click', function() {
        $('#div_search_goods').hide();
    });

    //搜索商品
    $('#btn_search_goods').on('click', function() {
        var url = "<?php echo urlMall('store_groupbuy', 'search_goods');?>";
        url += '&' + $.param({goods_name: $('#search_goods_name').val()});
        $('#div_goods_search_result').load(url);
    });

    $('#div_goods_search_result').on('click', 'a.demo', function() {
        $('#div_goods_search_result').load($(this).attr('href'));
        return false;
    });

    //选择商品
    $('#div_goods_search_result').on('click', '[nctype="btn_add_groupbuy_goods"]', function() {
        var goods_commonid = $(this).attr('data-goods-commonid');
        $.get('<?php echo urlMall('store_groupbuy', 'groupbuy_goods_info');?>', {goods_commonid: goods_commonid}, function(data) {
            if(data.result) {
                $('#groupbuy_goods_id').val(data.goods_id);
                $('#groupbuy_goods_image').attr('src', data.goods_image);
                $('#groupbuy_goods_name').text(data.goods_name);
                $('[nctype="groupbuy_goods_price"]').text(data.goods_price);
                $('#input_groupbuy_goods_price').val(data.goods_price);
                $('[nctype="groupbuy_goods_href"]').attr('href', data.goods_href);
                $('[nctype="groupbuy_goods_info"]').show();
                $('#div_search_goods').hide();
            } else {
                showError(data.message);
            }
        }, 'json');
    });

    //图片上传
    $('[nctype="btn_upload_image"]').fileupload({
        dataType: 'json',
            url: "<?php echo urlMall('store_groupbuy', 'image_upload');?>",
            add: function(e, data) {
                $parent = $(this).parents('dd');
                $input = $parent.find('[nctype="groupbuy_image"]');
                $img = $parent.find('[nctype="img_groupbuy_image"]');
                data.formData = {old_groupbuy_image:$input.val()};
                $img.attr('src', "<?php echo MALL_TEMPLATES_URL.'/images/loading.gif';?>");
                data.submit();
            },
            done: function (e,data) {
                var result = data.result;
                $parent = $(this).parents('dd');
                $input = $parent.find('[nctype="groupbuy_image"]');
                $img = $parent.find('[nctype="img_groupbuy_image"]');
                if(result.result) {
                    $img.prev('i').hide();
                    $img.attr('src', result.file_url);
                    $img.show();
                    $input.val(result.file_name);
                } else {
                    showError(data.message);
                }
            }
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

    jQuery.validator.methods.lessThanGoodsPrice= function(value, element) {
        var goods_price = $("#input_groupbuy_goods_price").val();
        return Number(value) < Number(goods_price);
    };

    jQuery.validator.methods.checkGroupbuyGoods = function(value, element) {
        var start_time = $("#start_time").val();
        var result = true;
        $.ajax({
            type:"GET",
            url:'<?php echo urlMall('store_groupbuy', 'check_groupbuy_goods');?>',
            async:false,
            data:{start_time: start_time, goods_id: value},
            dataType: 'json',
            success: function(data){
                if(!data.result) {
                    result = false;
                }
            }
        });
        return result;
    };

    //页面输入内容验证
    $("#add_form").validate({
        errorPlacement: function(error, element){
            var error_td = element.parent('dd').children('span');
            error_td.append(error);
        },
        onfocusout: false,
    	submitHandler:function(form){
    		ajaxpost('add_form', '', '', 'onerror');
    	},
        rules : {
            groupbuy_name: {
                required : true
            },
            start_time : {
                required : true,
                greaterThanDate : '<?php echo date('Y-m-d H:i',$output['groupbuy_start_time']);?>'
            },
            end_time : {
                required : true,
<?php if (!$output['isOwnMall']) { ?>
                lessThanDate : '<?php echo date('Y-m-d H:i',$output['current_groupbuy_quota']['end_time']);?>',
<?php } ?>
                greaterThanStartDate : true
            },
            groupbuy_goods_id: {
                required : true,
                checkGroupbuyGoods: true
            },
            groupbuy_price: {
                required : true,
                number : true,
                lessThanGoodsPrice: true,
                min : 0.01,
                max : 1000000
            },
            virtual_quantity: {
                required : true,
                digits : true
            },
            upper_limit: {
                required : true,
                digits : true
            },
            groupbuy_image: {
                required : true
            }
        },
        messages : {
            groupbuy_name: {
                required : '<i class="icon-exclamation-sign"></i><?php echo $lang['group_name_error'];?>'
            },
            start_time : {
                required : '<i class="icon-exclamation-sign"></i>团购开始时间不能为空',
                greaterThanDate : '<i class="icon-exclamation-sign"></i><?php echo sprintf('团购开始时间必须大于{0}',date('Y-m-d H:i',$output['current_groupbuy_quota']['start_time']));?>'
            },
            end_time : {
                required : '<i class="icon-exclamation-sign"></i>团购结束时间不能为空',
<?php if (!$output['isOwnMall']) { ?>
                lessThanDate : '<i class="icon-exclamation-sign"></i><?php echo sprintf('团购结束时间必须小于{0}',date('Y-m-d H:i',$output['current_groupbuy_quota']['end_time']));?>',
<?php } ?>
                greaterThanStartDate : '<i class="icon-exclamation-sign"></i>结束时间必须大于开始时间'
            },
            groupbuy_goods_id: {
                required : '<i class="icon-exclamation-sign"></i><?php echo $lang['group_goods_error'];?>',
                checkGroupbuyGoods: '该商品已经参加了同时段的活动'
            },
            groupbuy_price: {
                required : '<i class="icon-exclamation-sign"></i><?php echo $lang['groupbuy_price_error'];?>',
                number : '<i class="icon-exclamation-sign"></i><?php echo $lang['groupbuy_price_error'];?>',
                lessThanGoodsPrice: '<i class="icon-exclamation-sign"></i>团购价格必须小于商品价格',
                min : '<i class="icon-exclamation-sign"></i><?php echo $lang['groupbuy_price_error'];?>',
                max : '<i class="icon-exclamation-sign"></i><?php echo $lang['groupbuy_price_error'];?>'
            },
            virtual_quantity: {
                required : '<i class="icon-exclamation-sign"></i><?php echo $lang['virtual_quantity_error'];?>',
                digits : '<i class="icon-exclamation-sign"></i><?php echo $lang['virtual_quantity_error'];?>'
            },
            upper_limit: {
                required : '<i class="icon-exclamation-sign"></i><?php echo $lang['sale_quantity_error'];?>',
                digits : '<i class="icon-exclamation-sign"></i><?php echo $lang['sale_quantity_error'];?>'
            },
            groupbuy_image: {
                required : '<i class="icon-exclamation-sign"></i>团购图片不能为空'
            }
        }
    });

	$('#li_1').click(function(){
		$('#li_1').attr('class','active');
		$('#li_2').attr('class','');
		$('#demo').hide();
	});

	$('#goods_demo').click(function(){
		$('#li_1').attr('class','');
		$('#li_2').attr('class','active');
		$('#demo').show();
	});

	$('.des_demo').click(function(){
		if($('#des_demo').css('display') == 'none'){
            $('#des_demo').show();
        }else{
            $('#des_demo').hide();
        }
	});

    $('.des_demo').ajaxContent({
        event:'click', //mouseover
            loaderType:"img",
            loadingMsg:"<?php echo MALL_TEMPLATES_URL;?>/images/loading.gif",
            target:'#des_demo'
    });
});

function insert_editor(file_path){
	KE.appendHtml('goods_body', '<img src="'+ file_path + '">');
}

(function(data) {
    var s = '<option value="0"><?php echo $lang['text_no_limit']; ?></option>';
    if (typeof data.children != 'undefined') {
        if (data.children[0]) {
            $.each(data.children[0], function(k, v) {
                s += '<option value="'+v+'">'+data['name'][v]+'</option>';
            });
        }
    }
    $('#class_id').html(s).change(function() {
        var ss = '<option value="0"><?php echo $lang['text_no_limit']; ?></option>';
        var v = this.value;
        if (parseInt(v) && data.children[v]) {
            $.each(data.children[v], function(kk, vv) {
                ss += '<option value="'+vv+'">'+data['name'][vv]+'</option>';
            });
        }
        $('#s_class_id').html(ss);
    });
})($.parseJSON('<?php echo json_encode($output['groupbuy_classes']); ?>'));
</script>
