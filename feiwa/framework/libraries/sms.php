<?php
/**
 * 手机短信类
 *
 *
 *
 * @山东破浪网络科技有限公司提供技术支持 授权请购买FeiWa授权
 * @license    http://www.feiwa.org
 * @link       联系电话：0539-889333 客服QQ：2116198029
 */
defined('ByFeiWa') or exit('Access Invalid!');

class Sms {
    /**
     * 发送手机短信
     * @param unknown $mobile 手机号
     * @param unknown $content 短信内容
     */
    public function send($mobile,$content) {
       $feiwa_sms_type=C('feiwa_sms_type');
	  
		//破浪+
        if($feiwa_sms_type==1)
        {
            return $this->mysend_polang($mobile,$content);//破浪
        }
        //破浪-
    }
	//破浪+
    function mysend_polang($mobile,$content){
        require_once(BASE_DATA_PATH.'/api/polang/HttpClient.class.php');
        $pageContents = HttpClient::quickPost('http://211.147.242.161:9999/sms.aspx', array(
            'action' => 'send',
            'userid' => urlencode(C('feiwa_sms_tgs')),
            'account'=> urlencode(C('feiwa_sms_zh')),
            'password'=> urlencode(C('feiwa_sms_pw')),
            'mobile'=> $mobile,
            'content'=> $content,
            'sendtime'=> '',
            'extno'=> ''
        ));
        $x = new SimpleXmlElement($pageContents); 
        if($x->returnstatus=='Success'){
          return "发送成功";
        }
        else{
          return $x->message;
        }
    }
    //破浪-

 
}
