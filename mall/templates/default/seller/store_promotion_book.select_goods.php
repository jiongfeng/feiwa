<?php defined('ByFeiWa') or exit('Access Invalid!');?>
<?php if(!empty($output['goods_list']) && is_array($output['goods_list'])){?>

<div class="alert alert-block mt10">
  <ul class="mt5">
    <li>1、该插件模块为商业版专用，如有需要可前往官方下载</li>
    <li>2、插件下载地址<a href="http://www.feiwa.org/thread-14-1-1.html" target="_blank">http://www.feiwa.org/thread-14-1-1.html</a></li>
    <li>2、查看功能演示可前往官方演示站<a href="http://www.demo.feiwa.org/" target="_blank">http://www.demo.feiwa.org/</a></li>
  </ul>
</div>
<div class="pagination"><?php echo $output['show_page'];?></div>
<?php } else { ?>
<div><?php echo $lang['no_record'];?></div>
<?php } ?>