<?php
defined('PHP168_PATH') or die();



$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$config = &$core->CONFIG;
	include template($this_system, 'allow_ip','admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$config = isset($_POST['config']) && is_array($_POST['config']) ? $_POST['config'] : array();
	
	$config['allow_ip']['enabled'] = isset($config['allow_ip']['enabled']) ? ($config['allow_ip']['enabled'] == 1 ? 1 : 0) : 0;
	
	$config['allow_ip']['collectip'] = isset($config['allow_ip']['collectip']) ? explode("\r\n", trim($config['allow_ip']['collectip'])) : array();
	$config['allow_ip']['collectip'] = empty($config['allow_ip']['collectip'])? array() : array_flip($config['allow_ip']['collectip']);
	
	$config['allow_ip']['beginip'] = isset($config['allow_ip']['beginip']) ? trim($config['allow_ip']['beginip']) : '';
	$config['allow_ip']['endip'] = isset($config['allow_ip']['endip']) ? trim($config['allow_ip']['endip']) : '';
	
	$config['allow_ip']['ruleoutip'] = isset($config['allow_ip']['ruleoutip']) ? explode("\r\n", trim($config['allow_ip']['ruleoutip'])) : array();
	$config['allow_ip']['ruleoutip'] = empty($config['allow_ip']['ruleoutip'])? array() : array_flip($config['allow_ip']['ruleoutip']);
	
	$config['allow_ip']['admin_beginip'] = isset($config['allow_ip']['admin_beginip']) ? trim($config['allow_ip']['admin_beginip']) : '';
	$config['allow_ip']['admin_endip'] = isset($config['allow_ip']['admin_endip']) ? trim($config['allow_ip']['admin_endip']) : '';
	
    $config['allow_ip']['admin'] = isset($config['allow_ip']['admin']) ? explode("\r\n", trim($config['allow_ip']['admin'])) : array();
	$config['allow_ip']['admin'] = empty($config['allow_ip']['admin'])? array() : array_flip($config['allow_ip']['admin']);
	
	$core->set_config($config);
	message('done',$this_url);
}
