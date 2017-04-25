<?php defined('ByFeiWa') or exit('Access Invalid!');?>
<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div class="alert alert-block mt10">
  <ul class="mt5">
    <li>1、该插件模块为商业版专用，如有需要可前往官方下载</li>
    <li>2、插件下载地址<a href="http://www.feiwa.org/thread-16-1-1.html" target="_blank">http://www.feiwa.org/thread-16-1-1.html</a></li>
    <li>2、查看功能演示可前往官方演示站<a href="http://www.demo.feiwa.org/" target="_blank">http://www.demo.feiwa.org/</a></li>
  </ul>
</div>
<script type="text/javascript">
$(document).ready(function(){
    //页面输入内容验证
	$("#add_form").validate({
		errorPlacement: function(error, element){
			var error_td = element.parent('dd').children('span');
			error_td.append(error);
		},
		submitHandler:function(form){
			var unit_price = parseInt(<?php echo intval(C('promotion_combo_price'));?>);
			var quantity = parseInt($("#combo_quota_quantity").val());
			var price = unit_price * quantity;
			showDialog('确认购买?您总共需要支付'+price+'元', 'confirm', '', function(){ajaxpost('add_form', '', '', 'onerror');});
		},
		rules : {
			combo_quota_quantity : {
				required : true,
				digits : true,
				range : [1,12]
			}
		},
		messages : {
			combo_quota_quantity : {
				required : '<i class="icon-exclamation-sign"></i>套餐购买数量不能为空，且必须为1~12之间的整数',
				digits : '<i class="icon-exclamation-sign"></i>套餐购买数量不能为空，且必须为1~12之间的整数',
				range : '<i class="icon-exclamation-sign"></i>套餐购买数量不能为空，且必须为1~12之间的整数'
			}
		}
	});
});
</script> 
