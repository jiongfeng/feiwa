
/**
 * 删除购物车
 * @param cart_id
 */
function drop_cart_item(cart_id){
    var jjgId = $('#cart_id' + cart_id).attr('data-jjg') || -1;
    var parent_tr = $('#cart_item_' + cart_id).parent();
    var amount_span = $('#cart_totals');
    showDialog('确认删除吗?', 'confirm', '', function(){
        $.getJSON('index.php?app=cart&feiwa=del&cart_id=' + cart_id, function(result){
            if(result.state){
                //删除成功
                if(result.quantity == 0){//判断购物车是否为空
                    window.location.reload();    //刷新
                } else {
                    $('tr[feiwa_group="'+cart_id+'"]').remove();//移除本商品或本套装
                    if (parent_tr.children('tr').length == 2) {//只剩下店铺名头和店铺合计尾，则全部移除
                        parent_tr.remove();
                    }
                    calc_cart_price(jjgId);
                }
            }else{
                alert(result.msg);
            }
        });
    });
}

/**
 * 更改购物车数量
 * @param cart_id
 * @param input
 */
function change_quantity(cart_id, input){
    var jjgId = $('#cart_id' + cart_id).attr('data-jjg') || -1;
    var subtotal = $('#item' + cart_id + '_subtotal');
    //暂存为局部变量，否则如果用户输入过快有可能造成前后值不一致的问题
    var _value = input.value;
    $.getJSON('index.php?app=cart&feiwa=update&cart_id=' + cart_id + '&quantity=' + _value, function(result){
        $(input).attr('changed', _value);
        if(result.state == 'true'){
            $('#item' + cart_id + '_price').html(parseFloat(result.goods_price).toFixed(2));
            subtotal.html(parseFloat(result.subtotal).toFixed(2));
            $('#cart_id'+cart_id).val(cart_id+'|'+_value);
            $(input).val(result.goods_num);

            var bl_id = $(input).attr('bl_id');
            $('em[ncType="blnum'+bl_id+'"]').html(result.goods_num);
            $('em[ncType="bltotal'+bl_id+'"]').each(function(){
            	$(this).html((parseFloat($(this).attr('price'))*result.goods_num).toFixed(2));
            });
        }

        if(result.state == 'invalid'){
          subtotal.html(0.00);
          $('#cart_id'+cart_id).remove();
          $('tr[feiwa_group="'+cart_id+'"]').addClass('item_disabled');
          $(input).parent().next().html('');
          $(input).parent().removeClass('ws0').html('已下架');
          showDialog(result.msg, 'error','','','','','','','','',3);
        }

        if(result.state == 'shortage'){
          $('#item' + cart_id + '_price').html(parseFloat(result.goods_price).toFixed(2));
          $('#cart_id'+cart_id).val(cart_id+'|'+result.goods_num);
          $(input).val(result.goods_num);
          subtotal.html(parseFloat(result.subtotal).toFixed(2));
          showDialog(result.msg, 'error','','','','','','','','',3);
        }

        if(result.state == '') {
            //更新失败
            showDialog(result.msg, 'error','','','','','','','','',2);
            $(input).val($(input).attr('changed'));
        }
        calc_cart_price(jjgId);
    });
}

/**
 * 购物车减少商品数量
 * @param cart_id
 */
function decrease_quantity(cart_id){
    var item = $('#input_item_' + cart_id);
    var orig = Number(item.val());
    if(orig > 1){
        item.val(orig - 1);
        item.keyup();
    }
}

/**
 * 购物车增加商品数量
 * @param cart_id
 */
function add_quantity(cart_id){
    var item = $('#input_item_' + cart_id);
    var orig = Number(item.val());
    item.val(orig + 1);
    item.keyup();
}

/**
 * 购物车商品统计
 */
var calc_cart_price = (function() {

    var realCalculate = function() {
        //每个店铺商品价格小计
        obj = $('table[feiwa_type="table_cart"]');
        if(obj.children('tbody').length==0) return;
        //购物车已选择商品的总价格
        var allTotal = 0;
        obj.children('tbody').each(function(){
            //购物车每个店铺已选择商品的总价格
            var eachTotal = 0;
            $(this).find('em[feiwa_type="eachGoodsTotal"]').each(function(){
                if ($(this).parent().parent().find('input[type="checkbox"]').eq(0).attr('checked') != 'checked') return;
                eachTotal = eachTotal + parseFloat($(this).html());
            });
            $(this).find('em.jjg-item-when-calculation').each(function() {
                eachTotal += parseFloat(this.innerHTML) || 0;
            });
            allTotal += eachTotal;
            $(this).children('tr').last().find('em[feiwa_type="eachStoreTotal"]').eq(0).html(number_format(eachTotal,2));
        });
        $('#cartTotal').html(number_format(allTotal,2));
    };

    window.jjgRecalculator = realCalculate;

    return function(jjgId) {
        // jjg callback
        if (window.jjgCallback) {
            window.jjgCallback(jjgId);
        }
        realCalculate();
    }
})();

$(function(){
    calc_cart_price(0);
    $('#selectAll').on('click',function(){
        if ($(this).attr('checked')) {
            $('input[type="checkbox"]').attr('checked',true);
            $('input[type="checkbox"]:disabled').attr('checked',false);
            if ($('input[feiwa_type="eachGoodsCheckBox"]:checked').size() > 0) {
            	$('#next_submit').on('click',function(){$('#form_buy').submit();}).addClass('ok');	
            }
        } else {
            $('input[type="checkbox"]').attr('checked',false);
            $('#next_submit').unbind('click').removeClass('ok');
        }
        calc_cart_price(0);
    });
    $('input[feiwa_type="eachGoodsCheckBox"]').on('click',function(){
        var jjgId = $(this).attr('data-jjg') || -1;
        if (!$(this).attr('checked')) {
            $('#selectAll').attr('checked',false);
            if ($('input[feiwa_type="eachGoodsCheckBox"]:checked').size() == 0) {
            	$('#next_submit').unbind('click').removeClass('ok');
            }
        } else {
            // 如果都选中 则全选复选框是选中的
            var b = true;
            $('input[feiwa_type="eachGoodsCheckBox"]').not(this).not(':disabled').each(function() {
                if (!this.checked) {
                    b = false;
                    return false;
                }
            });
            if (b) {
                $('#selectAll').attr('checked', true);
            }
            $('#next_submit').on('click',function(){$('#form_buy').submit();}).addClass('ok');
        }
        calc_cart_price(jjgId);
    });
//    $('#next_submit').on('click',function(){
//        if ($(document).find('input[feiwa_type="eachGoodsCheckBox"]:checked').size() == 0) {
//            showDialog('请选中要结算的商品', 'eror','','','','','','','','',2);
//            return false;
//        }else {
//            $('#form_buy').submit();
//        }
//    });

    if ($('input[feiwa_type="eachGoodsCheckBox"]:checked').size() == 0) {
    	$('#next_submit').unbind('click');
    } else {
    	$('#next_submit').on('click',function(){$('#form_buy').submit()}).addClass('ok');
    }

});