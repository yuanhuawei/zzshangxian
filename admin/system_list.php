<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	load_language($core, 'config');

	$list = $core->list_systems();
	
	$uninstall_system = $this_controller->check_admin_action('uninstall_system');

	include template($core, 'system_list', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$table_prefixes = isset($_POST['table_prefix']) ? (array)$_POST['table_prefix'] : array();
	$enables = isset($_POST['enables']) ? (array)$_POST['enables'] : array();
	
	//修改系统安装表前缀
	foreach($table_prefixes as $system => $prefix){
		$system = preg_replace('/[^a-zA-Z0-9_]/', '', $system);
		$prefix = preg_replace('/[^a-zA-Z0-9_\.]/', '', $prefix);
		
		$DB_master->update(
			$core->TABLE_ .'system',
			array(
				'table_prefix' => $prefix
			),
			"name = '$system'"
		);
	}
	
	//禁用或开启模块
	foreach($enables as $system => $v){
		$system = basename($system);
		
		$v = empty($v) ? 0 : 1;
		$DB_master->update(
			$core->TABLE_ .'system',
			array('enabled' => $v),
			"name = '$system'"
		);
	}
	
	require PHP168_PATH .'inc/cache.func.php';
	cache_system_module();
	
	message('done', HTTP_REFERER);
}

