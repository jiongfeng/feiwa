<?php defined('ByFeiWa') or exit('Access Invalid!');?>

<div class="alert alert-block mt10">
  <ul class="mt5">
    <li>1、该插件模块为商业版专用，如有需要可前往官方下载</li>
    <li>2、插件下载地址<a href="http://www.feiwa.org/thread-15-1-1.html" target="_blank">http://www.feiwa.org/thread-15-1-1.html</a></li>
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

    jQuery.validator.addMethod("checkFCodePrefix", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);       
    },'<i class="icon-exclamation-sign"></i>请填写不多于5位的英文字母或数字');
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
            g_fccount: {
                required : true,
                range : [1,500]
            },
            g_fcprefix: {
                required : true,
                checkFCodePrefix : true,
                rangelength : [3,5]
            }
        },
        messages : {
            g_fccount: {
                required : "<i class='icon-exclamation-sign'></i>请填写F码生成数量",
                range : "<i class='icon-exclamation-sign'></i>请填写500以内的数量"
            },
            g_fcprefix: {
                required : "<i class='icon-exclamation-sign'></i>请填写不多于5位的英文字母或数字",
                rangelength : "<i class='icon-exclamation-sign'></i>请填写不多于5位的英文字母或数字"
            }
        }
    });
});
</script>