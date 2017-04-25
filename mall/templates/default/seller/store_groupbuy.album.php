<div class="alert alert-block mt10">
  <ul class="mt5">
    <li>1、该插件模块为商业版专用，如有需要可前往官方下载</li>
    <li>2、插件下载地址<a href="http://www.feiwa.org/thread-8-1-1.html" target="_blank">http://www.feiwa.org/thread-8-1-1.html</a></li>
  </ul>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('.demo').ajaxContent({
		event:'click', //mouseover
		loaderType:'img',
		loadingMsg:'<?php echo MALL_TEMPLATES_URL;?>/images/loading.gif',
		target:'#des_demo'
	});
	$('#jump_menu').change(function(){
		$('#select_s').attr('href',$('#select_s').attr('href')+"&id="+$('#jump_menu').val());
		$('.sample_demo').ajaxContent({
			event:'click', //mouseover
			loaderType:'img',
			loadingMsg:'<?php echo MALL_TEMPLATES_URL;?>/images/loading.gif',
			target:'#des_demo'
		});
		$('#select_s').click();
	});
});
</script>