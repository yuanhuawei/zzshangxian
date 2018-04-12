<?php
defined('PHP168_PATH') or die();

/**
* 插件管理
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	$system = isset($_GET['system']) ? $_GET['system'] : 'core';

	if($system != 'core' && !isset($core->systems[$system]))
		message('no_such_system');

	load_language($core, 'config');
	
	$uninstall_plugin = $this_controller->check_admin_action('uninstall_plugin');
	
	$list = $core->plugins;
	
	include template($core, 'plugin_list', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){

	$enables = isset($_POST['enables']) ? (array)$_POST['enables'] : array();
	
	//禁用或开启插件
	foreach($enables as $plugin => $v){
		$plugin = basename($plugin);
		
		$v = empty($v) ? 0 : 1;
		$DB_master->update(
			$core->TABLE_ .'plugin',
			array('enabled' => $v),
			"name = '$plugin'"
		);
	}
	
	require PHP168_PATH .'inc/cache.func.php';
	cache_system_module();
	
	message('done', HTTP_REFERER);
}