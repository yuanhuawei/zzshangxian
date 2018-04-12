<?php
defined('PHP168_PATH') or die();



$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$config = &$core->CONFIG;
	include template($this_system, 'stop_ip','admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$config = isset($_POST['config']) && is_array($_POST['config']) ? $_POST['config'] : array();
	
	$config['stop_ip']['enabled'] = isset($config['stop_ip']['enabled']) ? ($config['stop_ip']['enabled'] == 1 ? 1 : 0) : 0;
	
	$config['stop_ip']['forbidip'] = isset($config['stop_ip']['forbidip']) ? explode("\r\n",trim($config['stop_ip']['forbidip'])) : array();
	$config['stop_ip']['forbidip'] = empty($config['stop_ip']['forbidip']) ? array() : array_flip($config['stop_ip']['forbidip']);
	
	$config['stop_ip']['beginip'] = isset($config['stop_ip']['beginip']) ? trim($config['stop_ip']['beginip']) : '';
	$config['stop_ip']['endip'] = isset($config['stop_ip']['endip']) ? trim($config['stop_ip']['endip']) : '';
	
	$core->set_config($config);
	message('done',$this_url);
}
