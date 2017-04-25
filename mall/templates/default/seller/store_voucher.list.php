<?php defined('ByFeiWa') or exit('Access Invalid!');?>
  <div class="alert alert-block mt10">
  <ul class="mt5">
    <li>1、该插件模块为商业版专用，如有需要可前往官方下载</li>
    <li>2、插件下载地址<a href="http://www.feiwa.org/thread-18-1-1.html" target="_blank">http://www.feiwa.org/thread-18-1-1.html</a></li>
    <li>2、查看功能演示可前往官方演示站<a href="http://www.demo.feiwa.org/" target="_blank">http://www.demo.feiwa.org/</a></li>
  </ul>
</div>

<script type="text/javascript">
$(document).ready(function(){
    $('#voucher_list_div').find('.demo').ajaxContent({
        event:'click', //mouseover
        loaderType:"img",
        loadingMsg:"<?php echo MALL_TEMPLATES_URL;?>/images/transparent.gif",
        target:'#voucher_list_div'
    });

    <?php if (count($output['voucher_list'])>0) { ?>
    $("#voucher_exportbtn").show();
    <?php } ?>
});
</script>
