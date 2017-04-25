<?php defined('ByFeiWa') or exit('Access Invalid!');?>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL; ?>/js/jquery.ajaxContent.pack.js"></script>
<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<?php
$info = $output['data']['info'];
?>
<div class="alert alert-block mt10">
  <ul class="mt5">
    <li>1、该插件模块为商业版专用，如有需要可前往官方下载</li>
    <li>2、插件下载地址<a href="http://www.feiwa.org/thread-9-1-1.html" target="_blank">http://www.feiwa.org/thread-9-1-1.html</a></li>
    <li>2、查看功能演示可前往官方演示站<a href="http://www.demo.feiwa.org/" target="_blank">http://www.demo.feiwa.org/</a></li>
  </ul>
</div>

<div id="cou-level-newly" style="display:none;">
        <div data-cou-level-item="__level" class="feiwast-cou-rule">
          <div class="rule-note">
            <h5>新增规则：<a href="javascript:;" class="ncbtn-mini ncbtn-grapefruit" data-cou-level-remove="__level"><i class="icon-trash"></i>删除</a></h5>
            <span>购买同一加价购活动商品消费满
            <input type="text" class="w50" name="cou_level[__level][mincost]" value="" />
            元，即可换购最多
            <input type="text" class="w30" name="cou_level[__level][maxcou]" value="0" />
            件（0为不限）优惠商品，换购商品如下：<a data-cou-level-sku-choose-button="__level" href="javascript:;" class="ncbtn"><i class="icon-gift"></i>添加换购商品</a></span></div>
          <div data-cou-level-item="__level">
              <div class="div-goods-select-box">
                <div data-cou-level-sku-choose-container="__level"></div>
                <a data-cou-level-sku-close-button="__level" class="close" href="javascript:;" style="display:none;right:-10px;">&#215;</a> </div></div>
          <table class="feiwast-default-table mb15">
            <thead>
              <tr>
                <th colspan="2">换购商品</th>
                <th class="w100"> 原价(元)</th>
                <th class="w100"> 换购价(元)</th>
                <th class="handle">操作</th>
              </tr>
            </thead>
            <tbody class="bd-line" id="cou-level-sku-container-__level">
            </tbody>
          </table>
        </div>
</div>

<table style="display:none;">
  <tbody id="cou-level-sku-newly">
    <tr class="off-shelf" data-cou-level-selected-sku="__id" data-level="__level">
      <td class="w50"><div class="shelf-state">
          <div class="pic-thumb"> <img alt="" data-src="__imgUrl" /> </div>
        </div></td>
      <td class="tl"><a href="<?php echo urlMall('goods', 'index', array('goods_id' => '__id', )); ?>"> __name </a></td>
      <td class="goods-price w90" nctype="bundling_data_price"><s> __price </s></td>
      <td class="w90"><input type="text" class="w50" name="cou_level[__level][skus][__id]" value="__price" data-max-price="__price" /></td>
      <td class="nscs-table-handle w50"><span> <a href="javascript:;" class="btn-bittersweet" data-cou-level-sku-remove="__id"> <i class="icon-ban-circle"></i>
        <p>移除</p>
        </a> </span></td>
    </tr>
  </tbody>
</table>

<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui-timepicker-addon/jquery-ui-timepicker-addon.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui-timepicker-addon/jquery-ui-timepicker-addon.min.css"  />
<script>
$(function() {

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
            cou_name : {
                required : true
            }
        },
        messages : {
            cou_name : {
                required : '<i class="icon-exclamation-sign"></i>活动名称不能为空'
            }
        }
    });

    // ajax添加商品
    $('#cou-sku-choose-btn').ajaxContent({
        event: 'click',
        loaderType: "img",
        loadingMsg: MALL_TEMPLATES_URL + "/images/loading.gif",
        target: '#cou-sku-options'
    }).click(function() {
        $(this).hide();
        $('#cou-sku-close-btn').show();
    });
    $('#cou-sku-close-btn').click(function() {
        $(this).hide();
        $('#cou-sku-options').html('');
        $('#cou-sku-choose-btn').show();
    });

    $('#cou-sku-item-results [data-cou-sku-remove-button]').live('click', function() {
        $(this).parents('tr').remove();

        // 未参加活动的商品显示“设置为活动商品”按钮
        var id = $(this).attr('data-cou-sku-remove-button');
        $("div[data-cou-sku-switch-disabled='"+id+"']").hide();
        $("div[data-cou-sku-switch-enabled='"+id+"']").show();
    });

    var nextId = (function() {
        var i = 10000;
        return function() {
            return ++i;
        };
    })();

    // ajax添加规则
    $('#cou-level-add-button').click(function() {
        var id = nextId();
        var h = $('#cou-level-newly').html();
        h = h.replace(/__level/g, id);
        $('#cou-level-container').append(h);
    });

    // 规则移除按钮
    $('[data-cou-level-remove]').live('click', function() {
        var id = $(this).attr('data-cou-level-remove');
        $("[data-cou-level-item='"+id+"']").remove();
    });

    var couLevelSkuChooseTriggered = function(id, url) {
        $("[data-cou-level-sku-choose-container='"+id+"']").load(
            url || 'index.php?app=store_promotion_cou&feiwa=cou_level_sku&level='+id,
            function() {
                $("[data-cou-level-selected-sku]").each(function() {
                    var sku = $(this).attr('data-cou-level-selected-sku');
                    setCouLevelSkuAddButton(sku, 0);
                });
            }
        );
    };

    // 选择换购商品按钮
    $('[data-cou-level-sku-choose-button]').live('click', function() {
        var id = $(this).attr('data-cou-level-sku-choose-button');
        $("[data-cou-level-sku-choose-button='"+id+"']").hide();
        $("[data-cou-level-sku-close-button='"+id+"']").show();
        couLevelSkuChooseTriggered(id);
    });

    $('[data-cou-level-sku-choose-container] a.demo').live('click', function() {
        var id = $(this).parents('[data-cou-level-sku-choose-container]').attr('data-cou-level-sku-choose-container');
        var url = this.href;
        couLevelSkuChooseTriggered(id, url);
        return false;
    });

    $('[data-cou-level-sku-choose-container] a[nctype="search_a"]').live('click', function() {
        var id = $(this).parents('[data-cou-level-sku-choose-container]').attr('data-cou-level-sku-choose-container');
        var url = this.href;
        url += '&stc_id=' + $('#cou_level_sku_stc_id_'+id).val();
        url += '&keyword=' + encodeURIComponent($('#cou_level_sku_keyword_'+id).val());
        couLevelSkuChooseTriggered(id, url);
        return false;
    });

    // 关闭选择换购商品选择框
    $('[data-cou-level-sku-close-button]').live('click', function() {
        var id = $(this).attr('data-cou-level-sku-close-button');
        $(this).hide();
        $("[data-cou-level-sku-choose-button='"+id+"']").show();
        $("[data-cou-level-sku-choose-container='"+id+"']").html('');
    });

    var setCouLevelSkuAddButton = function(sku, b) {
        if (b) {
            $("[data-cou-level-sku-switch-enabled='"+sku+"']").show();
            $("[data-cou-level-sku-switch-disabled='"+sku+"']").hide();
        } else {
            $("[data-cou-level-sku-switch-enabled='"+sku+"']").hide();
            $("[data-cou-level-sku-switch-disabled='"+sku+"']").show();
        }
    };

    window.couLevelSkuInSearch = {};

    // 设置为换购商品
    $("[data-cou-level-sku-add-button]").live('click', function() {
        var sku = $(this).attr('data-cou-level-sku-add-button');
        var id = $(this).attr('data-level');

        var h = $('#cou-level-sku-newly').html();
        h = h.replace(/__level/g, id);
        h = h.replace(/__(\w+)/g, function($m, $1) {
            return window.couLevelSkuInSearch[sku][$1];
        });

        var $h = $(h);
        $h.find('img[data-src]').each(function() {
            this.src = $(this).attr('data-src');
        });

        $('#cou-level-sku-container-'+id).append($h);
        setCouLevelSkuAddButton(sku, 0);
    });

    // 移除已选换购商品按钮
    $("[data-cou-level-sku-remove]").live('click', function() {
        var sku = $(this).attr('data-cou-level-sku-remove');
        $("[data-cou-level-selected-sku='"+sku+"']").remove();
        setCouLevelSkuAddButton(sku, 1);
    });

    // 换购商品换购价不能高于原价

    $('input[data-max-price]').live('keyup', function() {
        var p = parseFloat(this.value) || 0;
        var mp = parseFloat($(this).attr('data-max-price')) || 0;
        if (p > mp) {
            alert('换购商品换购价不能高于原价，请重新填写！');
            this.value = '';
            this.focus();
            return false;
        }
    });

});
</script>
