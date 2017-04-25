<?php defined('ByFeiWa') or exit('Access Invalid!');?>

<div class="tabmenu">
  <?php include template('layout/submenu');?>
<?php if ($output['isOwnMall']) { ?>
  <a class="ncbtn ncbtn-mint" href="javascript:void(0);" nctype="select_goods"><i class="icon-plus-sign"></i>添加商品</a>
<?php } else { ?>
  <?php if(empty($output['book_quota'])) { ?>
  <a class="ncbtn ncbtn-aqua" href="<?php echo urlMall('store_promotion_book', 'book_quota_add');?>" title="购买套餐"><i class="icon-money"></i>购买套餐</a>
  <?php } else { ?>
  <a class="ncbtn ncbtn-mint" href="javascript:void(0);" nctype="select_goods" style="right:100px"><i class="icon-plus-sign"></i>添加商品</a>
  <a class="ncbtn ncbtn ncbtn-aqua" href="<?php echo urlMall('store_promotion_book', 'book_renew');?>"><i class="icon-money"></i>套餐续费</a>
  <?php } ?>
<?php } ?>
</div>

<?php if ($output['isOwnMall']) { ?>
<div class="alert alert-block mt10">
  <ul class="mt5">
    <li>1、该插件模块为商业版专用，如有需要可前往官方下载</li>
    <li>2、插件下载地址<a href="http://www.feiwa.org/thread-14-1-1.html" target="_blank">http://www.feiwa.org/thread-14-1-1.html</a></li>
    <li>2、查看功能演示可前往官方演示站<a href="http://www.demo.feiwa.org/" target="_blank">http://www.demo.feiwa.org/</a></li>
  </ul>
</div>
<?php } else { ?>
<!-- 有可用套餐，发布活动 -->
<?php } ?>

<?php if ($output['isOwnMall'] || (!empty($output['book_quota']) && $output['book_quota']['bkq_endtime'] > TIMESTAMP)) { ?>
<!-- 商品搜索 -->


<?php }else{?>
<!-- 没有可用套餐，购买 -->
<?php }?>
<script>
$(function(){
    // 验证是否已经选择商品
    checked_no_promotion();

    // 显示搜索框
    $('a[nctype="select_goods"]').click(function(){
        $('div[nctype="div_goods_select"]').show();
    });
    // 隐藏搜索框
    $('a[nctype="btn_hide_goods_select"]').click(function(){
        $('div[nctype="div_goods_select"]').hide();
    });

    // 搜索商品
    $('input[nctype="btn_search_goods"]').click(function(){
        _url = '<?php echo urlMall('store_promotion_book', 'book_select_goods');?>';
        $('div[nctype="div_goods_search_result"]').html('').load(_url + '&goods_name='+$('input[nctype="search_goods_name"]').val());
    });
    $('div[nctype="div_goods_select"]').on('click', '.demo', function(){
        $('div[nctype="div_goods_search_result"]').load($(this).attr('href'));
        return false;
    });

    $('div[nctype="div_goods_select"]').on('click', 'a[nctype="a_choose_goods"]', function(){
        _gid = $(this).attr('data-gid');
        _type = $(this).attr('data-type');
        CUR_DIALOG = ajax_form('choose_goods', '预定商品规则设定', '<?php echo urlMall('store_promotion_book', 'choosed_goods');?>&gid='+_gid+'&type='+_type, 640);
    });

    // 删除商品
    $('tbody[nctype="choose_goods_list"]').on('click','a[nctype="del_choosed"]', function(){
        $this = $(this);
        _url = '<?php echo urlMall('store_promotion_book', 'del_choosed_goods');?>';
        eval('var data_str = ' + $(this).attr('data-param'));
        $.getJSON(_url, {gid : data_str.gid, type : data_str.type}, function(data){
            if (data.result == 'true') {
                $this.parents('tr:first').fadeOut("slow",function(){
                    $(this).remove();
                    checked_no_promotion();
                });
            } else {
                showError(data.msg);
            }
        });
    });
});


function choose_goods(data, type) {
    // 插入数据
    _tr = $('<tr class="bd-line"></tr>')
        .append('<td></td>')
        .append('<td><div class="pic-thumb"><a target="_blank" href="' + data.url + '"><img src="' + data.goods_image + '"></a></div></td>')
        .append('<td class="tl"><dl class="goods-name"><dt><a target="_blank" href="' + data.url + '">' + data.goods_name + '</a></dt><dd>' + data.gc_name + '</dd></dl></td>');
        if (type == 'book') {
            _tr.append('<td>定金</td>')
                .append('<td class="tl"><dl><dt>结束时间：' + data.book_down_time + '</dt><dd>定&#12288;&#12288;金：￥' + data.book_down_payment + '</dd><dd>尾&#12288;&#12288;款：￥' + data.book_final_payment + '</dd></dl></td>');
        } else if (type == 'presell') {
            _tr.append('<td>全款</td><td class="tl"><dl><dt>发货时间：' + data.presell_deliverdate + '</dt></dl></td>');
        }
        _tr.append('<td>￥' + data.goods_price + '</td>')
        .append('<td class="nscs-table-handle"><span><a class="btn-grapefruit" href="javascript:void(0);" data-param="{gid:'+ data.goods_id +', type:\'' + type + '\'}" nctype="del_choosed"><i class="icon-trash"></i><p>删除</p></a></span></td>')
        .appendTo('tbody[nctype="choose_goods_list"]');
    // 验证是否已经选择商品
    checked_no_promotion();
}
// 验证是否已经选择商品
function checked_no_promotion() {
    if ($('tbody[nctype="choose_goods_list"]').children('tr').length == 1) {
        $('tr[nctype="tr_no_promotion"]').show();
    } else {
        $('tr[nctype="tr_no_promotion"]').hide();
    }
}
</script>