<?php
defined('PHP168_PATH') or die();

$controller = &$core->controller($core);
$controller->check_admin_action('install_system') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	include template($this_system, 'install', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$config = isset($_POST['config']) && is_array($_POST['config']) ? $_POST['config'] : array();
	
	$this_system->set_config($config);
	
	require PHP168_PATH .'admin/install_system.php';
	
}