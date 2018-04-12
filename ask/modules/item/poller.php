<?php
defined('PHP168_PATH') or die();

$this_controller->check_action($ACTION) or message('no_privilege');

P8_AJAX_REQUEST or message('ask_error', $this_system->controller, 3);

if(REQUEST_METHOD == 'GET'){
	
	//是否允许匿名投诉
	$allow_anonymous_poller = !empty($this_system->CONFIG['allow_anonymous_poller']) ? true : false;
	//投诉内容字符长度
	$poller_length = !empty($this_system->CONFIG['poller_length']) ? intval($this_system->CONFIG['poller_length']) : 150;

	$id = !empty($_GET['id'])? intval($_GET['id']) : 0;		
	$allow_poller = false;
	
	if(!empty($id) && $this_controller->check_exists(array('id'=>$id))){
		$allow_poller = true;
		$is_creator = !empty($UID) && $this_controller->check_exists(array('id'=>$id, 'uid'=>$UID)) ? true : false;
	}
	
	include template($this_module, 'poller');
}
elseif(REQUEST_METHOD == 'POST'){
	
	$json = $this_controller->post_poller($_POST) or die();
	echo jsonencode($json);
}
exit;