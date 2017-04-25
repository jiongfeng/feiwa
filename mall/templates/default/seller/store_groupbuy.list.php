<?php defined('ByFeiWa') or exit('Access Invalid!');?>

<div class="tabmenu">
  <?php include template('layout/submenu');?>
<?php if ($output['isOwnMall']) { ?>
  <a href="<?php echo urlMall('store_groupbuy', 'groupbuy_add_vr'); ?>" style="right:100px" class="ncbtn ncbtn-mint" title="新增虚拟商品团购"><i class="icon-plus-sign"></i>新增虚拟团购</a>
  <a href="<?php echo urlMall('store_groupbuy', 'groupbuy_add');?>" class="ncbtn ncbtn-mint" title="<?php echo $lang['groupbuy_index_new_group'];?>"><i class="icon-plus-sign"></i><?php echo $lang['groupbuy_index_new_group'];?></a>
<?php } else { ?>

  <?php if(!empty($output['current_groupbuy_quota'])) { ?>
  <a href="<?php echo urlMall('store_groupbuy', 'groupbuy_add_vr'); ?>" style="right:200px" class="ncbtn ncbtn-mint" title="新增虚拟商品团购"><i class="icon-plus-sign"></i>新增虚拟团购</a>
  <a href="<?php echo urlMall('store_groupbuy', 'groupbuy_add');?>" style="right:100px" class="ncbtn ncbtn-mint" title="<?php echo $lang['groupbuy_index_new_group'];?>"><i class="icon-plus-sign"></i><?php echo $lang['groupbuy_index_new_group'];?></a>
  <a class="ncbtn ncbtn-aqua" href="<?php echo urlMall('store_groupbuy', 'groupbuy_quota_add');?>" title="套餐续费"><i class="icon-money"></i>套餐续费</a>
  <?php } else { ?>
  <a class="ncbtn ncbtn-aqua" href="<?php echo urlMall('store_groupbuy', 'groupbuy_quota_add');?>" title="购买套餐"><i class="icon-money"></i>购买套餐</a>
  <?php } ?>
<?php } ?>

</div>
<?php if ($output['isOwnMall']) { ?>
<div class="alert alert-block mt10">
  <ul class="mt5">
    <li>1、该插件模块为商业版专用，如有需要可前往官方下载</li>
    <li>2、插件下载地址<a href="http://www.feiwa.org/thread-8-1-1.html" target="_blank">http://www.feiwa.org/thread-8-1-1.html</a></li>
  </ul>
</div>
<?php } else { ?>
<?php } ?>