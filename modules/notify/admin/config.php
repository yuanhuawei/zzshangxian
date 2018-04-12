<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$config = $core->get_config($SYSTEM, $MODULE);
	$info = include $this_module->path .'#.php';
	
	include template($this_module, 'config', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$_POST = p8_stripslashes2($_POST);
	
	$config = isset($_POST['config']) && is_array($_POST['config']) ? $_POST['config'] : array();
	
	$status = isset($config['status']) ? (array)$config['status'] : array();
	foreach($status as $k => $v){
		$k = intval($k);
		if($k <= 0 || !($v = trim($v))){
			unset($status[$k]);
			continue;
		}
		
		$status[$k] = html_entities($v);
	}
	$config['status'] = $status;
	
	$this_module->set_config($config);
	
	message('done', HTTP_REFERER);
}