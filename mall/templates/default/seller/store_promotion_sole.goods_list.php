<?php defined('ByFeiWa') or exit('Access Invalid!');?>

<div class="tabmenu">
  <?php include template('layout/submenu');?>

<?php if ($output['isOwnMall']) { ?>
  <a class="ncbtn ncbtn-mint" href="javascript:void(0);" nctype="select_goods"><i class="icon-plus-sign"></i>添加商品</a>
<?php } else { ?>
  <?php if(empty($output['sole_quota'])) { ?>
  <a class="ncbtn ncbtn-aqua" href="<?php echo urlMall('store_promotion_sole', 'sole_quota_add');?>" title="购买套餐"><i class="icon-money"></i>购买套餐</a>
  <?php } else { ?>
  <?php if ($output['sole_quota']['sole_state'] == 1) {?>
  <a class="ncbtn ncbtn-mint" href="javascript:void(0);" nctype="select_goods" style="right:100px"><i class="icon-plus-sign"></i>添加商品</a>
  <?php } ?>
  <a class="ncbtn ncbtn ncbtn-aqua" href="<?php echo urlMall('store_promotion_sole', 'sole_renew');?>"><i class="icon-money"></i>套餐续费</a>
  <?php } ?>
<?php } ?>

</div>

<?php if ($output['isOwnMall']) { ?>
<div class="alert alert-block mt10">
  <ul class="mt5">
    <li>1、该插件模块为商业版专用，如有需要可前往官方下载</li>
    <li>2、插件下载地址<a href="http://www.feiwa.org/thread-17-1-1.html" target="_blank">http://www.feiwa.org/thread-17-1-1.html</a></li>
    <li>2、查看功能演示可前往官方演示站<a href="http://www.demo.feiwa.org/" target="_blank">http://www.demo.feiwa.org/</a></li>
  </ul>
</div>
<?php } else { ?>
<!-- 有可用套餐，发布活动 -->
<?php } ?>

<?php if ($output['isOwnMall'] || (!empty($output['sole_quota']) && $output['sole_quota']['sole_state'] == 1)) { ?>
<!-- 商品搜索 -->

<?php }else{?>
<!-- 没有可用套餐，购买 -->

<?php }?>
<script>
$(function(){
    // 验证是否已经选择商品
    choosed_goods();

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
        var _url = '<?php echo urlMall('store_promotion_sole', 'sole_select_goods');?>';
        $('div[nctype="div_goods_search_result"]').html('').load(_url + '&goods_name' + $('input[nctype="search_goods_name"]').val());
    });
    $('div[nctype="div_goods_select"]').on('click', '.demo', function(){
        $('div[nctype="div_goods_search_result"]').load($(this).attr('href'));
        return false;
    });

    $('div[nctype="div_goods_select"],tr[data-gid]').on('click', 'a[nctype="a_choose_goods"]', function(){
        var _url = '<?php echo urlMall('store_promotion_sole', 'choosed_goods');?>';
        eval('var data_str =' + $(this).attr('data-param'));
        CUR_DIALOG = ajax_form('choosed_goods', '选择商品', _url + '&gid=' + data_str.gid, 640);
    });

    // 删除商品
    $('tbody[nctype="choose_goods_list"]').on('click','a[nctype="del_choosed"]', function(){
        $this = $(this);
        var _url = '<?php echo urlMall('store_promotion_sole', 'del_choosed_goods');?>';
        eval('var data_str = ' + $(this).attr('data-param'));
        $.getJSON(_url, {gid : data_str.gid}, function(data){
            if (data.result == 'true') {
                $this.parents('tr:first').fadeOut("slow",function(){
                    $(this).remove();
                    choosed_goods();
                });
            } else {
                showError(data.msg);
            }
        });
    });
});

// 验证是否已经选择商品
function choosed_goods() {
    if ($('tbody[nctype="choose_goods_list"]').children('tr').length == 1) {
        $('tr[nctype="tr_no_promotion"]').show();
    } else {
        $('tr[nctype="tr_no_promotion"]').hide();
    }
}

// 插入数据
function insert_data(data) {
    if (data.result == 'true') {
        // 插入数据
        $('<tr class="bd-line" data-gid="' + data.goods_id + '"></tr>')
            .append('<td></td>')
            .append('<td><div class="pic-thumb"><a target="_blank" href="' + data.url + '"><img src="' + data.goods_image + '"></a></div></td>')
            .append('<td class="tl"><dl class="goods-name"><dt><a target="_blank" href="' + data.url + '">' + data.goods_name + '</a></dt><dd>' + data.gc_name + '</dd></dl></td>')
            .append('<td>' + data.goods_price + '</td>')
            .append('<td>' + data.sole_price + '</td>')
            .append('<td class="nscs-table-handle">' + 
                    '<span><a class="btn-bluejeans" href="javascript:void(0);" data-param="{gid:'+ data.goods_id +'}" nctype="a_choose_goods"><i class="icon-edit"></i><p>编辑</p></a></span>' + 
                    '<span><a class="btn-grapefruit" href="javascript:void(0);" data-param="{gid:'+ data.goods_id +'}" nctype="del_choosed"><i class="icon-trash"></i><p>删除</p></a></span></td>')
            .appendTo('tbody[nctype="choose_goods_list"]');
            // 验证是否已经选择商品
        choosed_goods();
    } else {
        showError(data.msg);
    }
}

// 编辑数据
function update_data(data) {
    if (data.result == 'true') {
        $('tr[data-gid="' + data.goods_id + '"]').find('.goods-price:last').html('<?php echo $lang['currency'];?>' + data.sole_price);
        choosed_goods();
    } else {
        showError(data.msg);
    }
}
</script>