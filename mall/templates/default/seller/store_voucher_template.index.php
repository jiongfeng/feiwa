<?php defined('ByFeiWa') or exit('Access Invalid!');?>

<div class="tabmenu">
    <?php include template('layout/submenu');?>

<?php if ($output['isOwnMall']) { ?>
    <a class="ncbtn ncbtn-mint" style="right:100px" href="<?php echo urlMall('pointvoucher', 'index', array('store_id' => $_SESSION['store_id']));?>" target="_blank"><i class="icon-plus-sign"></i>查看活动列表</a>
    <a class="ncbtn ncbtn-mint" href="<?php echo urlMall('store_voucher', 'templateadd');?>"><i class="icon-plus-sign"></i><?php echo $lang['voucher_templateadd']; ?></a>
<?php } else { ?>
    <?php if(!empty($output['current_quota'])) { ?>
    <a class="ncbtn ncbtn-mint" style="right:200px" href="<?php echo urlMall('pointvoucher', 'index', array('store_id' => $_SESSION['store_id']));?>" target="_blank"><i class="icon-plus-sign"></i>查看活动列表</a>
    <a class="ncbtn ncbtn-mint" style="right:100px" href="<?php echo urlMall('store_voucher', 'templateadd');?>"><i class="icon-plus-sign"></i><?php echo $lang['voucher_templateadd']; ?></a>
	<a class="ncbtn ncbtn-aqua" href="<?php echo urlMall('store_voucher', 'quotaadd');?>" title=""><i class="icon-money"></i>套餐续费</a>
    <?php } else { ?>
    <a class="ncbtn ncbtn-aqua" href="<?php echo urlMall('store_voucher', 'quotaadd');?>" title=""><i class="icon-money"></i>购买套餐</a>
    <?php } ?>

<?php } ?>
</div>

<?php if ($output['isOwnMall']) { ?>
<div class="alert alert-block mt10">
  <ul class="mt5">
    <li>1、该插件模块为商业版专用，如有需要可前往官方下载</li>
    <li>2、插件下载地址<a href="http://www.feiwa.org/thread-18-1-1.html" target="_blank">http://www.feiwa.org/thread-18-1-1.html</a></li>
    <li>2、查看功能演示可前往官方演示站<a href="http://www.demo.feiwa.org/" target="_blank">http://www.demo.feiwa.org/</a></li>
  </ul>
</div>
<?php } else { ?>
<?php } ?>


<link type="text/css" rel="stylesheet" href="<?php echo RESOURCE_SITE_URL."/js/jquery-ui/themes/ui-lightness/jquery.ui.css";?>" />
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#txt_startdate').datepicker();
	$('#txt_enddate').datepicker();
});
</script>
