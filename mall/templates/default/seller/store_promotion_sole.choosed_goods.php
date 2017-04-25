<?php defined('ByFeiWa') or exit('Access Invalid!');?>
<style type="text/css">
.eject_con dl dt { width: 24%; }
.eject_con dl dd { width: 75%; }
.eject_con li p { float: none; }
</style>
<div class="alert alert-block mt10">
  <ul class="mt5">
    <li>1、该插件模块为商业版专用，如有需要可前往官方下载</li>
    <li>2、插件下载地址<a href="http://www.feiwa.org/thread-17-1-1.html" target="_blank">http://www.feiwa.org/thread-17-1-1.html</a></li>
    <li>2、查看功能演示可前往官方演示站<a href="http://www.demo.feiwa.org/" target="_blank">http://www.demo.feiwa.org/</a></li>
  </ul>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css" />
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js"></script> 
<script>
$(function(){
    // 提交表单
    $("#btn_submit").click(function(){
        $("#choosed_goods_form").submit();
    });

    // 页面输入内容验证
    $("#choosed_goods_form").validate({
        errorLabelContainer: $('#warning'),
        invalidHandler: function(form, validator) {
               $('#warning').show();
        },
        submitHandler:function(form){
            ajaxpost('choosed_goods_form', '', '', 'onerror');
        },
        rules : {
            sole_price: {
                required : true,
                max : <?php echo $output['goods_info']['goods_promotion_price'];?>,
                min : 0.01
            }
        },
        messages : {
            sole_price: {
                required : "<i class='icon-exclamation-sign'></i>专享价格不能为空，不能超过商品实际销售价格",
                max : "<i class='icon-exclamation-sign'></i>专享价格不能为空，不能超过商品实际销售价格",
                min : "<i class='icon-exclamation-sign'></i>专享价格不能为空，不能超过商品实际销售价格"
            }
        }
    });
});


</script>