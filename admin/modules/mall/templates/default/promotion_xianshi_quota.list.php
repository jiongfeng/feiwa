<?php defined('ByFeiWa') or exit('Access Invalid!');?>

<div class="page">
  <!-- 页面导航 -->
  <div class="fixed-bar">
    <div class="item-title">
      <div class="subject">
        <h3><?php echo $lang['promotion_xianshi'];?></h3>
        <h5><?php echo $lang['promotion_xianshi_subhead'];?></h5>
      </div>
      <ul class="tab-base nc-row">
        <?php   foreach($output['menu'] as $menu) {  if($menu['menu_type'] == 'text') { ?>
        <li><a href="JavaScript:void(0);" class="current"><?php echo $menu['menu_name'];?></a></li>
        <?php }  else { ?>
        <li><a href="<?php echo $menu['menu_url'];?>" ><?php echo $menu['menu_name'];?></a></li>
        <?php  } }  ?>
      </ul>
    </div>
  </div>

  <!-- 操作说明 -->
  <div class="explanation" id="explanation">
    <div class="title" id="checkZoom"><i class="fa fa-lightbulb-o"></i>
      <h4 title="<?php echo $lang['feiwa_prompts_title'];?>"><?php echo $lang['feiwa_prompts'];?></h4>
      <span id="explanationZoom" title="<?php echo $lang['feiwa_prompts_span'];?>"></span> </div>
    <ul>
      <li><?php echo $lang['xianshi_quota_list_help1'];?></li>
    </ul>
  </div>

  <div id="flexigrid"></div>
</div>

<script>
$(function(){
    $("#flexigrid").flexigrid({
        url: 'index.php?app=promotion_xianshi&feiwa=xianshi_quota_xml',
        colModel: [
            {display: '操作', name: 'operation', width: 60, sortable: false, align: 'center', className: 'handle-s'},
            {display: '店铺名称', name: 'store_name', width: 200, sortable: false, align: 'left'},
            {display: '开始时间', name: 'start_time_text', width: 120, sortable: false, align: 'center'},
            {display: '结束时间', name: 'end_time_text', width: 120, sortable: false, align: 'center'}
        ],
        searchitems: [
            {display: '店铺名称', name: 'store_name'}
        ],
        sortname: "quota_id",
        sortorder: "desc",
        title: '淘特卖套餐列表'
    });
});

</script>
