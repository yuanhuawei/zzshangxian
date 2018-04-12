<?php
defined('PHP168_PATH') or die();

/**
* 安装一个模块
**/

//不允许重新安装的模块
$denied = array('member', 'role', 'crontab', 'uploader', 'credit', 'label', 'message', 'pay', 'mail');

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'POST'){

	$system = isset($_POST['system']) ? $_POST['system'] : '';
	$module = isset($_POST['module']) ? $_POST['module'] : '';

	get_module($system, $module) or message('no_such_module');
	
	if($system == 'core'){
		if(in_array($module, $denied))
			message('core_module_can_not_be_uninstall');
		
		$this_system = &$core;
		$this_module = &$core->load_module($module);
	}else{
		$this_system = &$core->load_system($system);
		$this_module = &$this_system->load_module($module);
	}
	
	include PHP168_PATH .'install/install_module.php';
	
	unset($admin_menu);
	
	$admin_menu = new P8_Admin_Menu();
	$admin_menu->cache();

	unset($member_menu);
	$member_menu = new P8_Member_Menu();
	$member_menu->cache();
	
	require_once PHP168_PATH .'inc/cache.func.php';
	cache_system_module();
	
	message('done', HTTP_REFERER, 60);
}