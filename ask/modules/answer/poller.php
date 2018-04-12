<?php
defined('PHP168_PATH') or die();

$this_controller->check_action($ACTION) or message('no_privilege');

P8_AJAX_REQUEST or die();

if(REQUEST_METHOD == 'GET'){
	
	$id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
	$tid = !empty($_GET['tid']) ? intval($_GET['tid']) : 0;
	$allow_poller = false;	

	//投诉内容字符长度
	$poller_length = !empty($this_system->CONFIG['poller_length']) ? intval($this_system->CONFIG['poller_length']) : 150;

	//载入问题模块
	$item = &$this_system->load_module('item');
	$item_controller = &$core->controller($item);
	
	if(!empty($id) && !empty($tid) && $this_controller->check_exists(array('id'=>$id,'tid'=>$tid)) && $item_controller->check_exists(array('id'=>$tid))){
		$allow_poller = true;
		$is_creator = !empty($UID) && $this_controller->check_exists(array('id'=>$id,'tid'=>$tid,'uid'=>$UID)) ? true : false;
	}
	
	include template($this_module, 'poller');

}
elseif(REQUEST_METHOD == 'POST'){
	
	$json = $this_controller->post_poller($_POST) or die();
	echo jsonencode($json);
	exit;
	
}
