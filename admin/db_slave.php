<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	load_language($core, 'config');
	
	$config = $core->get_config('core', '');
	$info = include $core->path .'#.php';
	$config['D_B_slave'] = isset($config['D_B_slave']) ? $config['D_B_slave'] : array();
	
	include template($core, 'db_slave', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$config = !empty($_POST['config']['D_B_slave']) && is_array($_POST['config']['D_B_slave']) ? $_POST['config']['D_B_slave'] : array();
	
	if(empty($config['host']) || empty($config['port']) || empty($config['user']) || empty($config['password']) || empty($config['db'])){
		exit;
	}
	
	$db_slave = array();
	
	foreach($config['host'] as $k => $v){
		if(!strlen($config['host'][$k]) && !strlen($config['user'][$k]) && !strlen($config['db'][$k])) continue;
		
		$db_slave[] = array(
			'host' => $config['host'][$k],
			'port' => $config['port'][$k],
			'user' => $config['user'][$k],
			'password' => $config['password'][$k],
			'db' => $config['db'][$k],
		);
	}
	
	print_r($db_slave);
	
	exit;
	$core->set_config(array('DB_slave' => $db_slave));
	
	message('done');
}