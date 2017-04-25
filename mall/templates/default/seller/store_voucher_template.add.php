<link type="text/css" rel="stylesheet" href="<?php echo RESOURCE_SITE_URL."/js/jquery-ui/themes/ui-lightness/jquery.ui.css";?>"/>

  <div class="tabmenu">
    <?php include template('layout/submenu');?>
  </div>
	<div class="alert alert-block mt10">
  <ul class="mt5">
    <li>1、该插件模块为商业版专用，如有需要可前往官方下载</li>
    <li>2、插件下载地址<a href="http://www.feiwa.org/thread-18-1-1.html" target="_blank">http://www.feiwa.org/thread-18-1-1.html</a></li>
    <li>2、查看功能演示可前往官方演示站<a href="http://www.demo.feiwa.org/" target="_blank">http://www.demo.feiwa.org/</a></li>
  </ul>
</div>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js"></script>
<script>
//判断是否显示预览模块
<?php if (!empty($output['t_info']['voucher_t_customimg'])){?>
$('#customimg_preview').show();
<?php }?>
var year = <?php echo date('Y',$output['quotainfo']['quota_endtime']);?>;
var month = <?php echo intval(date('m',$output['quotainfo']['quota_endtime']));?>;
var day = <?php echo intval(date('d',$output['quotainfo']['quota_endtime']));?>;
function showcontent(choose_gettype){
	if(choose_gettype == 'pwd'){
		$("#eachlimit_dl").hide();
		$("#mgrade_dl").hide();
	}else{
		$("#eachlimit_dl").show();
		$("#mgrade_dl").show();
	}
}

$(document).ready(function(){
	showcontent('<?php echo $output['t_info']['voucher_t_gettype_key']; ?>');
	
	$("#gettype_sel").change(function(){
		var choose_gettype = $("#gettype_sel").val();
		showcontent(choose_gettype);
	});
    //日期控件
    $('#txt_template_enddate').datepicker();
    
    var currDate = new Date();
    var date = currDate.getDate();
    date = date + 1;
    currDate.setDate(date);
    
    $('#txt_template_enddate').datepicker( "option", "minDate", currDate);
<?php if (!$output['isOwnMall']) { ?>
    $('#txt_template_enddate').datepicker( "option", "maxDate", new Date(year,month-1,day));
<?php } ?>


    $('#txt_template_enddate').val("<?php echo $output['t_info']['voucher_t_end_date']?@date('Y-m-d',$output['t_info']['voucher_t_end_date']):'';?>");
    $('#customimg').change(function(){
		var src = getFullPath($(this)[0]);
		if(navigator.userAgent.indexOf("Firefox")>0){
			$('#customimg_preview').show();
			$('#customimg_preview').children('p').html('<img src="'+src+'">');
		}
	});

    $("#btn_add").click(function(){
        if($("#add_form").valid()){
        	var choose_gettype = $("#gettype_sel").val();
        	if(choose_gettype == 'pwd'){
            	var template_total = parseInt($("#txt_template_total").val());
            	if(template_total > 1000){
            		$("#txt_template_total").addClass('error');
            		$("#txt_template_total").parent('dd').children('span').append('<label for="txt_template_total" class="error"><i class="icon-exclamation-sign"></i>领取方式为卡密兑换的代金券，发放总数不能超过1000张</label>');
            		return false;
                }
            }
        	ajaxpost('add_form', '', '', 'onerror');
    	}
	});
	
    //表单验证
    $('#add_form').validate({
        errorPlacement: function(error, element){
	    	var error_td = element.parent('dd').children('span');
			error_td.append(error);
	    },
        rules : {
            txt_template_title: {
                required : true,
                rangelength:[1,50]
            },
            sc_id: {
            	required : true
            },
            txt_template_total: {
                required : true,
                digits : true,
                min: 1
            },
            txt_template_limit: {
                required : true,
                number : true
            },
            txt_template_describe: {
                required : true,
                rangelength:[1,200]
			},
			gettype_sel: {
				required : true
			}
        },
        messages : {
            txt_template_title: {
                required : '<i class="icon-exclamation-sign"></i><?php echo $lang['voucher_template_title_error'];?>',
                rangelength : '<i class="icon-exclamation-sign"></i><?php echo $lang['voucher_template_title_error'];?>'
            },
            sc_id: {
            	required : '<i class="icon-exclamation-sign"></i>请选择店铺分类'
            },
            txt_template_total: {
                required : '<i class="icon-exclamation-sign"></i><?php echo $lang['voucher_template_total_error'];?>',
                digits : '<i class="icon-exclamation-sign"></i><?php echo $lang['voucher_template_total_error'];?>',
                min: '<i class="icon-exclamation-sign"></i><?php echo $lang['voucher_template_total_error'];?>'
            },
            txt_template_limit: {
                required : '<i class="icon-exclamation-sign"></i><?php echo $lang['voucher_template_limit_error'];?>',
                number : '<i class="icon-exclamation-sign"></i><?php echo $lang['voucher_template_limit_error'];?>'
            },
            txt_template_describe: {
                required : '<i class="icon-exclamation-sign"></i><?php echo $lang['voucher_template_describe_error'];?>',
                rangelength:'<i class="icon-exclamation-sign"></i><?php echo $lang['voucher_template_describe_error'];?>'
			},
			gettype_sel: {
				required : '<i class="icon-exclamation-sign"></i>请选择领取方式'
			}
        }
    });
});
</script>