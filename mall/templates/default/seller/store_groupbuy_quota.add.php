<?php defined('ByFeiWa') or exit('Access Invalid!'); ?>
<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div class="feiwast-form-default">
  <div class="alert alert-block mt10">
  <ul class="mt5">
    <li>1、该插件模块为商业版专用，如有需要可前往官方下载</li>
    <li>2、插件下载地址<a href="http://www.feiwa.org/thread-8-1-1.html" target="_blank">http://www.feiwa.org/thread-8-1-1.html</a></li>
  </ul>
</div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
$(document).ready(function(){
    //页面输入内容验证
    $("#add_form").validate({
        errorPlacement: function(error, element){
            var error_td = element.parent('dd').children('span');
            error_td.append(error);
        },
    	submitHandler:function(form){
            var unit_price = <?php echo C('groupbuy_price');?>;
            var quantity = $("#groupbuy_quota_quantity").val();
            var price = unit_price * quantity;
            showDialog('确认购买？您总共需要支付'+price+'<?php echo $lang['feiwa_yuan'];?>', 'confirm', '', function(){
            	ajaxpost('add_form', '', '', 'onerror');
            	});
    	},
        rules : {
            groupbuy_quota_quantity : {
                required : true,
                digits : true,
                min : 1
            }
        },
        messages : {
            groupbuy_quota_quantity : {
                required : "<i class='icon-exclamation-sign'></i>数量不能为空且必须为数字",
                digits : "<i class='icon-exclamation-sign'></i>数量不能为空且必须为数字",
                min : "<i class='icon-exclamation-sign'></i>数量不能为空且必须为数字"
            }
        }
    });
});
</script>
