<?php defined('ByFeiWa') or exit('Access Invalid!');?>

<div class="eject_con">
  <div id="warning" class="alert alert-error"></div>
  <?php if ($output['error'] == '') {?>
  <div class="alert alert-block mt10">
  <ul class="mt5">
    <li>1、该插件模块为商业版专用，如有需要可前往官方下载</li>
    <li>2、插件下载地址<a href="http://www.feiwa.org/thread-14-1-1.html" target="_blank">http://www.feiwa.org/thread-14-1-1.html</a></li>
    <li>2、查看功能演示可前往官方演示站<a href="http://www.demo.feiwa.org/" target="_blank">http://www.demo.feiwa.org/</a></li>
  </ul>
</div>
  <?php } else {?>
  <table class="feiwast-default-table feiwast-promotion-buy">
    <tbody>
      <tr>
        <td colspan="20" class="norecord"><div class="no-promotion"><span><?php echo $output['error'];?></span></div></td>
      </tr>
    </tbody>
  </table>
  <?php }?>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css" />
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js"></script> 
<script>
$(function(){
    // 时间控件
    $('input[name="down_time"]').datepicker({minDate: 0<?php if (!checkPlatformStore()) { echo ", maxDate: '" . date('Y-m-d', $output['book_info']['bkq_endtime']) . "'";}?>});
    $('input[name="presell_deliverdate"]').datepicker({minDate: 0<?php if (!checkPlatformStore()) { echo ", maxDate: '" . date('Y-m-d', $output['book_info']['bkq_endtime']) . "'";}?>});
    // 提交表单
    $("#btn_submit").click(function(){
        $("#choosed_goods_form").submit();
    });
    // 计算合计总价
    $('input[name="down_payment"],input[name="total_payment"]').change(function(){
        totalPayment();
    });

    jQuery.validator.addMethod("checkDownPayment", function(value, element) {
        if (parseFloat($('input[name="total_payment"]').val()) * 0.2 >= parseFloat($('input[name="down_payment"]').val())) {
            return true;
        } else {
            return false;
        }
    },'<i class="icon-exclamation-sign"></i>定金价格不能超过预定价格的20%');

    // 页面输入内容验证
    $("#choosed_goods_form").validate({
        errorLabelContainer: $('#warning'),
        invalidHandler: function(form, validator) {
               $('#warning').show();
        },
        submitHandler:function(form){
            ajaxpost('choosed_goods_form', '', '', 'onerror');
        },
        rules : {
            total_payment: {
                required : true,
                max : <?php echo $output['goods_info']['goods_price'];?>,
                min : 0.01
            },
            down_payment: {
                required : true,
                number : true,
                min : 0.01,
                checkDownPayment : true
            },
            down_time: {
                required : true
            }
        },
        messages : {
            total_payment: {
                required : "<i class='icon-exclamation-sign'></i>合计总价不能为空，不能超过商品销售价格",
                max : "<i class='icon-exclamation-sign'></i>合计总价不能为空，不能超过商品销售价格",
                min : "<i class='icon-exclamation-sign'></i>合计总价不能为空，不能超过商品销售价格"
            },
            down_payment: {
                required : "<i class='icon-exclamation-sign'></i>定金价格不能为空，且必须小于商品价格",
                number : "<i class='icon-exclamation-sign'></i>定金价格不能为空，且必须小于商品价格",
                min : "<i class='icon-exclamation-sign'></i>定金价格不能为空，且必须小于商品价格"
            },
            down_time: {
                required : "<i class='icon-exclamation-sign'></i>请选择尾款支付时间"
            }
        }
    });
});

// 计算合计总价
function totalPayment() {
    _down = parseFloat($('input[name="down_payment"]').val());
    _total = parseFloat($('input[name="total_payment"]').val());

    _down = isNaN(_down) ? 0 : _down;
    _total = isNaN(_total) ? 0 : _total;
    _final = _total - _down;
    $('input[name="final_payment"]').val(_final.toFixed(2));
}
</script>