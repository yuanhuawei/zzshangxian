<?php
defined('PHP168_PATH') or die();

/**
* 管理支付方式
**/
//$this_module->list_interface(true);
if(REQUEST_METHOD == 'GET'){
	
	//列表
	$list = $this_module->list_interface();
	
	include template($this_module, 'list_interface', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	define('NO_ADMIN_LOG', true);
	
	//刷新支付方式
	$this_module->list_interface(true);
	
	message('done', HTTP_REFERER);
	
}