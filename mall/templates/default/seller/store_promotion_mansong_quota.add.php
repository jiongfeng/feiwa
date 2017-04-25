<?php defined('ByFeiWa') or exit('Access Invalid!');?>

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
<script>
$(document).ready(function(){
    //页面输入内容验证
    $("#add_form").validate({
        errorPlacement: function(error, element){
            var error_td = element.parent('dd').children('span');
            error_td.append(error);
        },
     	submitHandler:function(form){
            var unit_price = <?php echo $output['setting_config']['promotion_mansong_price'];?>;
            var quantity = $("#mansong_quota_quantity").val();
            var price = unit_price * quantity;
             showDialog('<?php echo $lang['mansong_quota_add_confirm'];?>'+price+'<?php echo $lang['feiwa_yuan'];?>', 'confirm', '', function(){ajaxpost('add_form', '', '', 'onerror');});
    	},
        rules : {
            mansong_quota_quantity : {
                required : true,
                digits : true,
                min : 1,
                max : 12
            }
        },
        messages : {
            mansong_quota_quantity : {
                required : '<i class="icon-exclamation-sign"></i><?php echo $lang['mansong_quota_quantity_error'];?>',
                digits : '<i class="icon-exclamation-sign"></i><?php echo $lang['mansong_quota_quantity_error'];?>',
                min : '<i class="icon-exclamation-sign"></i><?php echo $lang['mansong_quota_quantity_error'];?>',
                max : '<i class="icon-exclamation-sign"></i><?php echo $lang['mansong_quota_quantity_error'];?>'
            }
        }
    });
});
</script>
