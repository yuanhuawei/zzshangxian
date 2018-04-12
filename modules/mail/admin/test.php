<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){

	include template($this_module, 'test', 'admin');

}else if(REQUEST_METHOD == 'POST'){
	
	$_POST = p8_stripslashes2($_POST);
	$send_to = isset($_POST['send_to']) ? $_POST['send_to'] : '';
	
	if(strpos($send_to,',')!==false){
		$send_to = explode(',',$send_to);
	}else{
		$send_to = array($send_to);
	}
	
	foreach($send_to as $send){
		$params = array();
		$params['send_to'] = $send;
		$params['subject'] = isset($_POST['subject']) ? $_POST['subject'] : '';
		$params['message'] = isset($_POST['message']) ? $_POST['message'] : '';
		$this_module->set($params);
		$this_module->send() or message('fail');
	
	}
	message('done', HTTP_REFERER, 30);
}