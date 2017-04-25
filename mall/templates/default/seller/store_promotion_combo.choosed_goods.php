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
$(function(){	
    // 选择推荐组合按钮
    var _i = 1;
    $('a[nctype="select_goods"]').click(function(){
        $('div[nctype="feiwast-goods-combo"]').append('<div class="feiwast-form-goods-combo"><div class="combo-title">分类名称<input type="text" name="class['+ _i +']" value="默认' + _i + '" ><a href="javascript:void(0);" nctype="feiwast-goods-combo-del" class="ncbtn ncbtn-grapefruit"><i class="icon-trash"></i>删除</a></div><div class="combo-goods" nctype="choose_goods_list" data-i="' + _i + '"><ul></ul></div></div>');
        selected_box($('.feiwast-form-goods-combo', '#goods_combo').last());
        _i++;
    });

    // 关闭按钮
    $('a[nctype="btn_hide_goods_select"]').click(function(){
        $(this).parent().hide();
    });

    // 删除按钮
    $('div[nctype="feiwast-goods-combo"]').on('click', 'a[nctype="feiwast-goods-combo-del"]', function(){
        $(this).parents('.feiwast-form-goods-combo:first').remove();
    });

    // 所搜商品
    $('a[nctype="search_combo"]').click(function(){
        _url = "<?php echo urlMall('store_goods_online', 'search_goods');?>";
        _name = $(this).parents('tr').find('input[name="search_combo"]').val();
        $(this).parents('table:first').next().load(_url + '&name=' + _name);
    });

    // 分页
    $('div[nctype="combo_goods_list"]').on('click', 'a[class="demo"]', function(){
        $(this).parents('div[nctype="combo_goods_list"]').load($(this).attr('href'));
        return false;
    });

    $('#goods_combo')
    // 选择分类组
    .on('click', '.feiwast-form-goods-combo', function(){
        selected_box($(this));
    })
    // 删除推荐商品
    .on('click', 'a[nctype="del_choosed"]', function(){
        $(this).parents('li:first').remove();
    });
    

    // 选择商品
    $('div[nctype="combo_goods_list"]').on('click', 'a[nctype="a_choose_goods"]', function(){
        var _select_group = $('.selected > [nctype="choose_goods_list"]').last();
        _owner_i = _select_group.attr('data-i');
        eval('var data_str = ' + $(this).attr('data-param'));
        _li = $('<li></li>')
            .append('<input type="hidden" value="' + data_str.gid + '" name="combo[' + _owner_i + '][]">')
            .append('<div class="pic-thumb"> <span> <img src="' + data_str.gimage240 + '"> </span> </div>')
            .append('<dl><dt>' + data_str.gname + '</dt><dd>￥' + data_str.gprice + '</dd></dl>')
            .append('<a class="ncbtn-mini ncbtn-bittersweet" nctype="del_choosed" href="javascript:void(0);"><i class="icon-ban-circle"></i>取消推荐</a>');
        _select_group.find('ul').append(_li);
    });

    $('#goods_combo').submit(function(){
        ajaxpost('goods_combo', '', '', 'onerror');
    });
	//品牌索引过长滚条
	$("#ncscGoodsCombo").perfectScrollbar({suppressScrollX:true});
});

function selected_box($this) {
	$('.feiwast-form-goods-combo', '#goods_combo').removeClass('selected');
	$this.addClass('selected');
    $('.div-goods-select').show().find('input[name="search_combo"]').val('').end().find('a[nctype="search_combo"]').click();
}
</script> 
