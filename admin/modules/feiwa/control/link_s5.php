<?php
/**
 * 在线更新
 *客服QQ：2116198029
 */
defined('ByFeiWa') or exit('Access Invalid!');
class link_s5Control extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('link_s5');
	}
	    public function indexFeiwa() {
	    Tpl::setDirquna('feiwa');
		Tpl::showpage('link_s5.index');
	    	
		}
	
	
}