<div class="alert alert-block mt10">
  <ul class="mt5">
    <li>1、该插件模块为商业版专用，如有需要可前往官方下载</li>
    <li>2、插件下载地址<a href="http://www.feiwa.org/thread-13-1-1.html" target="_blank">http://www.feiwa.org/thread-13-1-1.html</a></li>
    <li>2、查看功能演示可前往官方演示站<a href="http://www.demo.feiwa.org/" target="_blank">http://www.demo.feiwa.org/</a></li>
  </ul>
</div>
<script>
$(function(){
	/* ajax添加商品  */
	$('.demo').unbind().ajaxContent({
		event:'click', //mouseover
		loaderType:"img",
		loadingMsg:MALL_TEMPLATES_URL+"/images/loading.gif",
		target:'#bundling_add_goods_ajaxContent'
	});

	$('a[nctype="search_a"]').click(function(){
		$(this).attr('href', $(this).attr('href')+'&stc_id='+$('select[name="stc_id"]').val()+ '&' +$.param({'keyword':$('input[name="b_search_keyword"]').val()}));
		$('a[nctype="search_a"]').ajaxContent({
			event:'dblclick', //mouseover
			loaderType:'img',
			loadingMsg:'<?php echo MALL_TEMPLATES_URL;?>/images/loading.gif',
			target:'#bundling_add_goods_ajaxContent'
		});
		$(this).dblclick();
		return false;
	});


	// 验证商品是否已经被选择。
	O = $('input[nctype="goods_id"]');
	A = new Array();
	if(typeof(O) != 'undefined'){
		O.each(function(){
			A[$(this).val()] = $(this).val();
		});
	}
	T = $('ul[nctype="bundling_goods_add_tbody"] li');
	if(typeof(T) != 'undefined'){
		T.each(function(){
			if(typeof(A[$(this).attr('nctype')]) != 'undefined'){
				$(this).children(':last').html('<a href="JavaScript:void(0);" onclick="bundling_operate_delete($(\'#bundling_tr_'+$(this).attr('nctype')+'\'), '+$(this).attr('nctype')+')" class="ncbtn-mini ncbtn-bittersweet"><i class="icon-ban-circle"></i><?php echo $lang['bundling_goods_add_bundling_exit'];?></a>');
			}
		});
	}
});

/* 添加商品 */
function bundling_goods_add(o){
	// 验证商品是否已经添加。
	var _bundlingtr = $('tbody[nctype="bundling_data"] tr:not(:first)');
	if(typeof(_bundlingtr) != 'undefined'){
		if(_bundlingtr.length == <?php echo C('promotion_bundling_goods_sum');?>){
			alert('<?php printf($lang['bundling_goods_add_enough_prompt'], C('promotion_bundling_goods_sum'));?>');
			return false;
		}
	}

    eval('var _data = ' + o.parent().attr('data-param'));
    if (_data.gstrong == 0) {
        alert('<?php echo $lang['bundling_goods_storage_not_enough'];?>');
        return false;
    }
    // 隐藏第一个tr
    $('tbody[nctype="bundling_data"]').children(':first').hide();
    // 插入数据
    $('<tr id="bundling_tr_' + _data.gid + '"></tr>')
        .append('<input type="hidden" nctype="goods_id" name="goods[g_' + _data.gid + '][gid]" value="' + _data.gid + '">')
        .append('<td class="w70"><input type="checkbox" name="goods[g_' + _data.gid + '][appoint]" value="1" checked="checked"></td>')
        .append('<td class="w50 "><div class="pic-thumb"><img nctype="bundling_data_img" ncname="' + _data.image + '" src="' + _data.src + '" onload="javascript:DrawImage(this,60,60)"></span></div></td>')
        .append('<td class="tl"><dl class="goods-name"><dt style="width: 300px;">' + _data.gname + '</dt></dl></td>')
        .append('<td class="w90 goods-price" nctype="bundling_data_price">' + _data.gprice + '</td>')
        .append('<td class="w90"><input type="text" nctype="price" name="goods[g_' + _data.gid + '][price]" value="' + _data.gprice + '" class="text w70"></td>')
        .append('<td class="nscs-table-handle w90"><span><a href="javascript:void(0);" onclick="bundling_operate_delete($(\'#bundling_tr_' + _data.gid + '\'), ' + _data.gid + ')" class="btn-bittersweet"><i class="icon-ban-circle"></i><p><?php echo $lang['bundling_goods_remove'];?></p></a></span></td>')
        .fadeIn().appendTo('tbody[nctype="bundling_data"]');

    $('li[nctype="' + _data.gid + '"]').children(':last').html('<a href="JavaScript:void(0);" class="ncbtn-mini ncbtn-bittersweet" onclick="bundling_operate_delete($(\'#bundling_tr_' + _data.gid + '\'), ' + _data.gid + ')"><i class="icon-ban-circle"></i><?php echo $lang['bundling_goods_add_bundling_exit'];?></a>');
    count_cost_price_sum();
    count_price_sum();
}

</script> 