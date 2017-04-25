<?php defined('ByFeiWa') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title"><a class="back" href="index.php?app=feiwa&feiwa=crontab" title="返回列表"><i class="fa fa-arrow-circle-o-left"></i></a>
      <div class="subject">
        <h3>计划任务设置</h3>
        <h5>当设置为自动的时候就会自动执行哦</h5>
      </div>
    </div>
  </div>

  <div class="explanation" id="explanation">
    <div class="title" id="checkZoom"><i class="fa fa-lightbulb-o"></i>
      <h4 title="<?php echo $lang['feiwa_prompts_title'];?>"><?php echo $lang['feiwa_prompts'];?></h4>
      <span id="explanationZoom" title="<?php echo $lang['feiwa_prompts_span'];?>"></span> </div>
    <ul>
      <li>计划任务可在此手动执行。</li>
      <li>设置为自动执行时当有人访问网站就会自动执行的哦。</li>
      <li>插件下载地址：<a href="http://www.feiwa.org/thread-21-1-1.html" target="_blank">http://www.feiwa.org/thread-21-1-1.html</a></li>
    </ul>
  </div>
</div>
<script>
//按钮先执行验证再提交表单
$(function(){$("#submitBtn").click(function(){
    if($("#crontab_form").valid()){
        $("#crontab_form").submit();
    }
	});
});

$(document).ready(function(){
	$('#crontab_form').validate({
        errorPlacement: function(error, element){
			var error_td = element.parent('dd').children('span.err');
            error_td.append(error);
        },
        rules : {
            crontab_name : {
                required : true
            },
            crontab_value : {
                required : true
            },
			crontab_is : {
                required : true
            }
        },
        messages : {
            crontab_name : {
                required : '<i class="fa fa-exclamation-circle"></i>请填写推荐词名称'
            },
            crontab_value : {
            	required : '<i class="fa fa-exclamation-circle"></i>请填写推荐词链接'
            },
			crontab_is : {
            	required : '<i class="fa fa-exclamation-circle"></i>请选择是否高亮'
            }
        }
    });
});
</script>