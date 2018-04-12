<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

//不允许卸载的模块
$denied = array('member', 'role', 'crontab', 'uploader', 'credit', 'label', 'message', 'pay', 'mail', 'dbm');

if(REQUEST_METHOD == 'POST'){

	$system = isset($_POST['system']) ? $_POST['system'] : '';
	$module = isset($_POST['module']) ? $_POST['module'] : '';
	
	get_module($system, $module) or message('no_such_module');
	
	$uninstall_module = $this_controller->check_admin_action('uninstall_module');
	
	load_language($core, 'config');
	
	if($system == 'core'){
		if(in_array($module, $denied))
			message('core_module_can_not_be_uninstall');
		
		$this_system = &$core;
		$this_module = $core->load_module($module);
		
	}else{
		$this_system = &$core->load_system($system);
		$this_module = &$this_system->load_module($module);
	}

	include PHP168_PATH .'install/uninstall_module.php';
	
	require_once PHP168_PATH .'inc/cache.func.php';
	cache_system_module();
	message('done');

}