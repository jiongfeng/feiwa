<?php
$inPageProducts = array();
?>
<div class="alert alert-block mt10">
  <ul class="mt5">
    <li>1、该插件模块为商业版专用，如有需要可前往官方下载</li>
    <li>2、插件下载地址<a href="http://www.feiwa.org/thread-9-1-1.html" target="_blank">http://www.feiwa.org/thread-9-1-1.html</a></li>
    <li>2、查看功能演示可前往官方演示站<a href="http://www.demo.feiwa.org/" target="_blank">http://www.demo.feiwa.org/</a></li>
  </ul>
</div>
<script>
$(function() {
    /* ajax添加商品  */
    $('.demo').unbind().ajaxContent({
        event: 'click',
        loaderType: "img",
        loadingMsg: MALL_TEMPLATES_URL+"/images/loading.gif",
        target: '#cou-sku-options'
    });

    /* ajax添加商品  */
    $('a[nctype="search_a"]').click(function(){
        $(this).attr('href', $(this).attr('href')+'&stc_id='+$('select[name="stc_id"]').val()+ '&' +$.param({'keyword':$('input[name="b_search_keyword"]').val()}));
        $('a[nctype="search_a"]').ajaxContent({
            event:'dblclick',
            loaderType:'img',
            loadingMsg:'<?php echo MALL_TEMPLATES_URL;?>/images/loading.gif',
            target:'#cou-sku-options'
        });
        $(this).dblclick();
        return false;
    });

    // 已参加活动的商品不显示“设置为活动商品”按钮
    $("#cou-sku-item-results tr[data-product-id]").each(function() {
        var id = $(this).attr('data-product-id');
        $("div[data-cou-sku-switch-disabled='"+id+"']").show();
        $("div[data-cou-sku-switch-enabled='"+id+"']").hide();
    });
});

var inPageProducts = <?php echo json_encode($inPageProducts); ?>;

/* 添加商品 */
function cou_sku_add_callback(id) {

    if ($("#cou-sku-item-results tr[data-product-id='"+id+"']").length > 0) {
        return false;
    }

    // console.log('s');
    var i = inPageProducts[id];

    var h = $('#cou-sku-item-tpl').html();
    h = h.replace(/__([a-zA-Z]+)/g, function(r, $1) {
        return i[$1];
    });

    var $h = $(h);
    $h.find('img[data-src]').each(function() {
        this.src = $(this).attr('data-src');
    });

    // console.log('s2');
    $('#cou-sku-item-results').append($h);

    // 已参加活动的商品不显示“设置为活动商品”按钮
    $("div[data-cou-sku-switch-disabled='"+id+"']").show();
    $("div[data-cou-sku-switch-enabled='"+id+"']").hide();
}

</script>
