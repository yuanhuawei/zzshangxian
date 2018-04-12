<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	$system = isset($_GET['system']) ? $_GET['system'] : 'core';

	if($system != 'core' && !isset($core->systems[$system]))
		message('no_such_system');

	load_language($core, 'config');
	
	if($system == 'core'){
		$list = $core->list_modules();
		
	}else{
		$this_system = &$core->load_system($system);
		$list = $this_system->list_modules();
	}
	
	$uninstall_module = $this_controller->check_admin_action('uninstall_module');
	$system_json = p8_json($core->systems);
	$module_json = p8_json($this_system->modules);
	
	include template($core, 'module_list', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$system = isset($_POST['system']) ? basename($_POST['system']) : 'core';
	$enables = isset($_POST['enables']) ? (array)$_POST['enables'] : array();
	
	//禁用或开启模块
	foreach($enables as $module => $v){
		$module = basename($module);
		
		$v = empty($v) ? 0 : 1;
		$DB_master->update(
			$core->TABLE_ .'module',
			array('enabled' => $v),
			"system = '$system' AND name = '$module'"
		);
	}
	
	require PHP168_PATH .'inc/cache.func.php';
	cache_system_module();
	
	message('done', HTTP_REFERER);
}