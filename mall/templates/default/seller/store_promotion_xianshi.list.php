<?php defined('ByFeiWa') or exit('Access Invalid!');?>

<div class="tabmenu">
  <?php include template('layout/submenu');?>
  <?php if ($output['isOwnMall']) { ?>
  <a class="ncbtn ncbtn-mint" href="<?php echo urlMall('store_promotion_xianshi', 'xianshi_add');?>"><i class="icon-plus-sign"></i><?php echo $lang['xianshi_add'];?></a>
  <?php } else { ?>
  <?php if(!empty($output['current_xianshi_quota'])) { ?>
  <a class="ncbtn ncbtn-mint" style="right:100px" href="<?php echo urlMall('store_promotion_xianshi', 'xianshi_add');?>"><i class="icon-plus-sign"></i><?php echo $lang['xianshi_add'];?></a> <a class="ncbtn ncbtn-aqua" href="<?php echo urlMall('store_promotion_xianshi', 'xianshi_quota_add');?>" title=""><i class="icon-money"></i>套餐续费</a>
  <?php } else { ?>
  <a class="ncbtn ncbtn-aqua" href="<?php echo urlMall('store_promotion_xianshi', 'xianshi_quota_add');?>" title=""><i class="icon-money"></i><?php echo $lang['xianshi_quota_add'];?></a>
  <?php } ?>
  <?php } ?>
</div>
<?php if ($output['isOwnMall']) { ?>
<div class="alert alert-block mt10">
  <ul class="mt5">
    <li>1、该插件模块为商业版专用，如有需要可前往官方下载</li>
    <li>2、插件下载地址<a href="http://www.feiwa.org/thread-11-1-1.html" target="_blank">http://www.feiwa.org/thread-11-1-1.html</a></li>
    <li>2、查看功能演示可前往官方演示站<a href="http://www.demo.feiwa.org/" target="_blank">http://www.demo.feiwa.org/</a></li>
  </ul>
</div>
<?php } else { ?>
<?php } ?>
<form id="submit_form" action="" method="post" >
  <input type="hidden" id="xianshi_id" name="xianshi_id" value="">
</form>
<script type="text/javascript">
    $(document).ready(function(){
        $('[nctype="btn_del_xianshi"]').on('click', function() {
            if(confirm('<?php echo $lang['feiwa_ensure_del'];?>')) {
                var action = "<?php echo urlMall('store_promotion_xianshi', 'xianshi_del');?>";
                var xianshi_id = $(this).attr('data-xianshi-id');
                $('#submit_form').attr('action', action);
                $('#xianshi_id').val(xianshi_id);
                ajaxpost('submit_form', '', '', 'onerror');
            }
        });
    });
</script> 
