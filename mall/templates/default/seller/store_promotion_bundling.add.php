<?php defined('ByFeiWa') or exit('Access Invalid!');?>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.ajaxContent.pack.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<style>
.pic_list .small_pic ul li {
	height: 100px;
}
.ui-sortable-helper {
	border: dashed 1px #F93;
	box-shadow: 2px 2px 2px rgba(153,153,153, 0.25);
	filter: alpha(opacity=75);
	-moz-opacity: 0.75;
	opacity: .75;
	cursor: ns-resize;
}
.ui-sortable-helper td {
	background-color: #FFC !important;
}
.ajaxload {
	display: block;
	width: 16px;
	height: 16px;
	margin: 100px 300px;
}
</style>
<input id="level2_flag" type="hidden" value="false" />
<input id="level3_flag" type="hidden" value="false" />
<div class="alert alert-block mt10">
  <ul class="mt5">
    <li>1、该插件模块为商业版专用，如有需要可前往官方下载</li>
    <li>2、插件下载地址<a href="http://www.feiwa.org/thread-13-1-1.html" target="_blank">http://www.feiwa.org/thread-13-1-1.html</a></li>
    <li>2、查看功能演示可前往官方演示站<a href="http://www.demo.feiwa.org/" target="_blank">http://www.demo.feiwa.org/</a></li>
  </ul>
</div>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/common.js"></script> 
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js"></script> 
<script src="<?php echo MALL_RESOURCE_SITE_URL;?>/js/store_bundling.js"></script> 
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.poshytip.min.js"></script> 
<script type="text/javascript">
var DEFAULT_GOODS_IMAGE = '<?php echo defaultGoodsImage(60);?>';
$(function(){
    jQuery.validator.addMethod('bundling_goods', function(value, element){
    	return $('tbody[nctype="bundling_data"] > tr').length >2?true:false;
    });
	//Ajax提示
    $('.tip').poshytip({
    	className: 'tip-yellowsimple',
    	showTimeout: 1,
    	alignTo: 'target',
    	alignX: 'left',
    	alignY: 'top',
    	offsetX: 5,
    	offsetY: -78,
    	allowTipHover: false
    });
    $('.tip2').poshytip({
    	className: 'tip-yellowsimple',
    	showTimeout: 1,
    	alignTo: 'target',
    	alignX: 'right',
    	alignY: 'center',
    	offsetX: 5,
    	offsetY: 0,
    	allowTipHover: false
    });
    //页面输入内容验证
    $("#add_form").validate({
        errorPlacement: function(error, element){
            var error_td = element.nextAll('span:first');
            error_td.append(error);
        },
     	submitHandler:function(form){
    		ajaxpost('add_form', '', '', 'onerror')
    	},
        rules : {
            bundling_name : {
                required : true
            },
            bundling_goods : {
				bundling_goods : true
	        },
            discount_price : {
				required : true,
				number : true
            }
        },
        messages : {
            bundling_name : {
                required : '<i class="icon-exclamation-sign"></i><?php echo $lang['bundling_add_name_error'];?>'
            },
            bundling_goods : {
            	bundling_goods : '<i class="icon-exclamation-sign"></i><?php echo $lang['bundling_add_goods_error'];?>'
            },
            discount_price : {
				required : '<i class="icon-exclamation-sign"></i><?php echo $lang['bundling_add_price_error_null'];?>',
				number : '<i class="icon-exclamation-sign"></i><?php echo $lang['bundling_add_price_error_not_num'];?>'
            }
        
        }
    });

	$('input[name="bundling_freight_choose"]').click(function(){
		if($(this).val() == '0'){
			$('#whops_buyer_box').show();
		}else{
			$('#whops_buyer_box').hide();
		}
	});

    check_bundling_data_length();
    <?php if(!empty($output['bundling_info'])){?>
    count_cost_price_sum(); // 计算商品原价
    count_price_sum();
    <?php }?>

    $('tbody[nctype="bundling_data"]').on('change', 'input[nctype="price"]', function(){
        count_price_sum();
    });
});


/* 删除商品 */
function bundling_operate_delete(o, id){
	o.remove();
	check_bundling_data_length();
	$('li[nctype="'+id+'"]').children(':last').html('<a href="JavaScript:void(0);" onclick="bundling_goods_add($(this))" class="ncbtn-mini ncbtn-mint"><i class="icon-plus"></i><?php echo $lang['bundling_goods_add_bundling'];?></a>');
	count_cost_price_sum();
}

function check_bundling_data_length(){
	if ($('tbody[nctype="bundling_data"] tr').length == 1) {
	    $('tbody[nctype="bundling_data"]').children(':first').show();
	}
}
</script>