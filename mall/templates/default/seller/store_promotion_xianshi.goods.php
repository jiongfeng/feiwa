<?php defined('ByFeiWa') or exit('Access Invalid!');?>
<?php if(!empty($output['goods_list']) && is_array($output['goods_list'])){?>

<div class="alert alert-block mt10">
  <ul class="mt5">
    <li>1、该插件模块为商业版专用，如有需要可前往官方下载</li>
    <li>2、插件下载地址<a href="http://www.feiwa.org/thread-11-1-1.html" target="_blank">http://www.feiwa.org/thread-11-1-1.html</a></li>
    <li>2、查看功能演示可前往官方演示站<a href="http://www.demo.feiwa.org/" target="_blank">http://www.demo.feiwa.org/</a></li>
  </ul>
</div>
<div class="pagination"><?php echo $output['show_page']; ?></div>
<?php } else { ?>
<div><?php echo $lang['no_record'];?></div>
<?php } ?>
<div id="dialog_add_xianshi_goods" style="display:none;">
  <input id="dialog_goods_id" type="hidden">
  <input id="dialog_input_goods_price" type="hidden">
  <div class="eject_con">
    <div id="dialog_add_xianshi_goods_error" class="alert alert-error">
      <label for="dialog_xianshi_price" class="error" ><i class='icon-exclamation-sign'></i>折扣价格不能为空，且必须小于商品价格</label>
    </div>
    <div class="selected-goods-info">
      <div class="goods-thumb"><img id="dialog_goods_img" src="" alt=""></div>
      <dl class="goods-info">
        <dt id="dialog_goods_name"></dt>
        <dd>销售价格：<strong class="red"><?php echo $lang['currency']; ?><font id="dialog_goods_price"></font></strong></dd>
        <dd>库存：<span id="dialog_goods_storage"></span> 件</dd>
      </dl>
    </div>
    <dl>
      <dt>限时折扣价格：</dt>
      <dd>
        <input id="dialog_xianshi_price" type="text" class="text w70">
        <em class="add-on"><i class="icon-renminbi"></i></em>
        <p class="hint">限时折扣价应低于正常商品售价，活动开始时，系统将自动转换销售价为促销价。</p>
      </dd>
    </dl>
    <div class="eject_con">
      <div class="bottom">
        <label class="submit-border"><a id="btn_submit" class="submit" href="javascript:void(0);">提交</a></label>
      </div>
    </div>
  </div>
</div>
