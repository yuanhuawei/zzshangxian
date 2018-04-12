<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	$system = $module = '';
	load_language($core, 'config');
	
	include template($this_module, 'cache', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	$type = isset($_POST['type']) ? $_POST['type'] : '';
	
	switch($type){
		case 'label':
			$this_module->cache();
		break;
		
		case 'data':
			$this_module->cache_data();
		break;
		
		default:
			
			$this_module->cache();
			$this_module->cache_data();
			
			
		break;
	}
	
	//Ìø»Ø×Ü»º´æ
	!empty($_POST['_all_cache_']) && message($BACKTO_ALL_CACHE);
	
	message('done',HTTP_REFERER);
}