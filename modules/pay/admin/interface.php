<?php
defined('PHP168_PATH') or die();

/**
* ����֧����ʽ
**/
//$this_module->list_interface(true);
if(REQUEST_METHOD == 'GET'){
	
	//�б�
	$list = $this_module->list_interface();
	
	include template($this_module, 'list_interface', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	define('NO_ADMIN_LOG', true);
	
	//ˢ��֧����ʽ
	$this_module->list_interface(true);
	
	message('done', HTTP_REFERER);
	
}