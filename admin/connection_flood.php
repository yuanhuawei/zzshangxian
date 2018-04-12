<?php
defined('PHP168_PATH') or die();



$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$config = $core->CONFIG;
	include template($this_system, 'connection_flood','admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$config = isset($_POST['config']) && is_array($_POST['config']) ? $_POST['config'] : array();
	
	$config['cc_enabled'] = isset($config['cc_enabled']) ? ($config['cc_enabled'] == 1 ? 1 : 0) : 0;
	$config['cc_num'] = isset($config['cc_num']) ? (preg_match("/^\\d+$/",$config['cc_num']) && $config['cc_num']> 9 ? $config['cc_num'] : 20) : 20;
	$config['cc_time'] = isset($config['cc_time']) ? (preg_match("/^\\d+$/",$config['cc_time'])? $config['cc_time'] : 1) : 1;
	
	$core->set_config($config);
	message('done',$this_url);
}
