<?php defined('ByFeiWa') or exit('Access Invalid!');?><div class="boxItem2 zoom hoverTab"><div class="tabCont"><?php if (!empty($output['code_sale_list']['code_info']) && is_array($output['code_sale_list']['code_info'])) { $i = 0; ?><?php foreach ($output['code_sale_list']['code_info'] as $key => $val) { $i++; ?> <a target="_blank" href="javascript:void(0)" class="<?php echo $i==1 ? 'now':'';?>"><?php echo $val['recommend']['name'];?></a> <?php } } ?></div><?php if (!empty($output['code_sale_list']['code_info']) && is_array($output['code_sale_list']['code_info'])) { $i = 0; ?> <?php foreach ($output['code_sale_list']['code_info'] as $key => $val) { $i++;  ?> <?php if(!empty($val['goods_list']) && is_array($val['goods_list'])) { ?><ul style="<?php echo $i==1 ? 'display: block':'display: none';?> ;" class="hoverCont "> <?php foreach($val['goods_list'] as $k => $v){ ?><li><a href="<?php echo urlMall('goods','index',array('goods_id'=>$v['goods_id'])); ?>" target="_blank"><p class="infoImg"><img alt="<?php echo $v['goods_name']; ?>" feiwa-url="<?php echo strpos($v['goods_pic'],'http')===0 ? $v['goods_pic']:UPLOAD_SITE_URL."/".$v['goods_pic'];?>" rel='lazy' src="<?php echo MALL_SITE_URL;?>/img/loading.gif" ></p> </a><div class="feiwa-rt"><a href="<?php echo urlMall('goods','index',array('goods_id'=>$v['goods_id'])); ?>" target="_blank">  </a><a target="_blank" href="<?php echo urlMall('goods','index',array('goods_id'=>$v['goods_id'])); ?>" class="infoItem2"><?php echo $v['goods_name']; ?></a> <p class="infoItem3 c999"><?php echo $v['goods_jingle']; ?></p><p class="price pink"> <i class="ft18">￥</i>  <b class="ft20"><?php echo $v['goods_price']; ?></b> </p> </div> </li><?php } ?> </ul><?php }}} ?> </div>