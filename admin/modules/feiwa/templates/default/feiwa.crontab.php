<?php defined('ByFeiWa') or exit('Access Invalid!');?>
<style>.progress{height:13px;overflow:hidden;background-color:#f5f5f5;border-radius:7px;-webkit-box-shadow:inset 0 1px 2px rgba(0, 0, 0, .1);box-shadow:inset 0 1px 2px rgba(0, 0, 0, .1);}
.progress-bar{color:#fff;float:left;background-color:#0a0;display:inline-block;font-size:12px;line-height:14px;text-align:center;}
.progress-bar:after{content:"\3000";}
.progress .progress-bar:last-child{border-radius:0 1px 1px 0;}
.progress-big{height:26px;border-radius:13px;}
.progress-big .progress-bar{font-size:14px;line-height:26px;}
.progress-big .progress-bar:last-child{border-radius:0 13px 13px 0;}
.progress-small{height:5px;border-radius:3px;}
.progress-small .progress-bar{font-size:6px;line-height:6px;}
.progress-small .progress-bar:last-child{border-radius:0 3px 3px 0;}
.progress-bar.bg-back,.progress-bar.bg-mix,.progress-bar.bg-white{color:inherit;}
@-webkit-keyframes progress-bar-active{from{background-position:30px 0;}to{background-position:0 0;}}
@keyframes progress-bar-active{from{background-position:30px 0;}to{background-position:0 0;}}
.progress-striped .progress-bar{background-image:-webkit-linear-gradient(45deg, rgba(255, 255, 255, .25) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .25) 50%, rgba(255, 255, 255, .25) 75%, transparent 75%, transparent);background-image:linear-gradient(45deg, rgba(255, 255, 255, .25) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .25) 50%, rgba(255, 255, 255, .25) 75%, transparent 75%, transparent);background-size:30px 30px;}
.progress.active .progress-bar{-webkit-animation:progress-bar-active 2s linear infinite normal;animation:progress-bar-active 2s linear infinite normal;}

</style>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <div class="subject">
        <h3>计划任务设置</h3>
        <h5>当设置为自动的时候就会自动执行哦</h5>
      </div>
      <?php echo $output['top_link'];?> </div>
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
