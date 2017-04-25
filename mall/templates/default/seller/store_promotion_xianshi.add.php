<?php defined('ByFeiWa') or exit('Access Invalid!');?>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div class="alert alert-block mt10">
  <ul class="mt5">
    <li>1、该插件模块为商业版专用，如有需要可前往官方下载</li>
    <li>2、插件下载地址<a href="http://www.feiwa.org/thread-11-1-1.html" target="_blank">http://www.feiwa.org/thread-11-1-1.html</a></li>
    <li>2、查看功能演示可前往官方演示站<a href="http://www.demo.feiwa.org/" target="_blank">http://www.demo.feiwa.org/</a></li>
  </ul>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui-timepicker-addon/jquery-ui-timepicker-addon.min.css"  />
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.ajaxContent.pack.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui-timepicker-addon/jquery-ui-timepicker-addon.min.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.iframe-transport.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.ui.widget.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.fileupload.js" charset="utf-8"></script>
<script>
$(document).ready(function(){
    <?php if(empty($output['xianshi_info'])) { ?>
    $('#start_time').datetimepicker({
        controlType: 'select'
    });

    $('#end_time').datetimepicker({
        controlType: 'select'
    });
    <?php } ?>
    
     //图片上传
    $('[nctype="btn_upload_image"]').fileupload({
        dataType: 'json',
            url: "<?php echo urlMall('store_promotion_xianshi', 'image_upload');?>",
            add: function(e, data) {
                $parent = $(this).parents('dd');
                $input = $parent.find('[nctype="xianshi_image"]');
                $img = $parent.find('[nctype="img_xianshi_image"]');
                data.formData = {old_xianshi_image:$input.val()};
                $img.attr('src', "<?php echo MALL_TEMPLATES_URL.'/images/loading.gif';?>");
                data.submit();
            },
            done: function (e,data) {
                var result = data.result;
                $parent = $(this).parents('dd');
                $input = $parent.find('[nctype="xianshi_image"]');
                $img = $parent.find('[nctype="img_xianshi_image"]');
                if(result.result) {
                    $img.prev('i').hide();
                    $img.attr('src', result.file_url);
                    $img.show();
                    $input.val(result.file_name);
                } else {
                    showError(data.message);
                }
            }
    });

    jQuery.validator.methods.greaterThanDate = function(value, element, param) {
        var date1 = new Date(Date.parse(param.replace(/-/g, "/")));
        var date2 = new Date(Date.parse(value.replace(/-/g, "/")));
        return date1 < date2;
    };
    jQuery.validator.methods.lessThanDate = function(value, element, param) {
        var date1 = new Date(Date.parse(param.replace(/-/g, "/")));
        var date2 = new Date(Date.parse(value.replace(/-/g, "/")));
        return date1 > date2;
    };
    jQuery.validator.methods.greaterThanStartDate = function(value, element) {
        var start_date = $("#start_time").val();
        var date1 = new Date(Date.parse(start_date.replace(/-/g, "/")));
        var date2 = new Date(Date.parse(value.replace(/-/g, "/")));
        return date1 < date2;
    };

    //页面输入内容验证
    $("#add_form").validate({
        errorPlacement: function(error, element){
            var error_td = element.parent('dd').children('span');
            error_td.append(error);
        },
        onfocusout: false,
    	submitHandler:function(form){
    		ajaxpost('add_form', '', '', 'onerror');
    	},
        rules : {
            xianshi_name : {
                required : true
            },
            start_time : {
                required : true,
                greaterThanDate : '<?php echo date('Y-m-d H:i',$output['current_xianshi_quota']['start_time']);?>'
            },
            sc_id: {
            	required : true
            },
            end_time : {
                required : true,
<?php if (!$output['isOwnMall']) { ?>
                lessThanDate : '<?php echo date('Y-m-d H:i',$output['current_xianshi_quota']['end_time']);?>',
<?php } ?>
                greaterThanStartDate : true
            },
            lower_limit: {
                required: true,
                digits: true,
                min: 1
            }
        },
        messages : {
            xianshi_name : {
                required : '<i class="icon-exclamation-sign"></i><?php echo $lang['xianshi_name_error'];?>'
            },
            start_time : {
            required : '<i class="icon-exclamation-sign"></i><?php echo sprintf($lang['xianshi_add_start_time_explain'],date('Y-m-d H:i',$output['current_xianshi_quota']['start_time']));?>',
                greaterThanDate : '<i class="icon-exclamation-sign"></i><?php echo sprintf($lang['xianshi_add_start_time_explain'],date('Y-m-d H:i',$output['current_xianshi_quota']['start_time']));?>'
            },
            sc_id: {
            	required : '<i class="icon-exclamation-sign"></i>请选择淘特卖分类'
            },
            end_time : {
            required : '<i class="icon-exclamation-sign"></i><?php echo sprintf($lang['xianshi_add_end_time_explain'],date('Y-m-d H:i',$output['current_xianshi_quota']['end_time']));?>',
<?php if (!$output['isOwnMall']) { ?>
                lessThanDate : '<i class="icon-exclamation-sign"></i><?php echo sprintf($lang['xianshi_add_end_time_explain'],date('Y-m-d H:i',$output['current_xianshi_quota']['end_time']));?>',
<?php } ?>
                greaterThanStartDate : '<i class="icon-exclamation-sign"></i><?php echo $lang['greater_than_start_time'];?>'
            },
            lower_limit: {
                required : '<i class="icon-exclamation-sign"></i>购买下限不能为空',
                digits: '<i class="icon-exclamation-sign"></i>购买下限必须为数字',
                min: '<i class="icon-exclamation-sign"></i>购买下限不能小于1'
            }
        }
    });



	$('#goods_demo').click(function(){
		$('#li_1').attr('class','');
		$('#li_2').attr('class','active');
		$('#demo').show();
	});

	$('.des_demo').click(function(){
		if($('#des_demo').css('display') == 'none'){
            $('#des_demo').show();
        }else{
            $('#des_demo').hide();
        }
	});

    $('.des_demo').ajaxContent({
        event:'click', //mouseover
            loaderType:"img",
            loadingMsg:"<?php echo MALL_TEMPLATES_URL;?>/images/loading.gif",
            target:'#des_demo'
    });
});

function insert_editor(file_path){
	KE.appendHtml('goods_body', '<img src="'+ file_path + '">');
}
</script>
