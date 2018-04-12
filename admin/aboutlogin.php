<?php
defined('PHP168_PATH') or die();



$this_controller->check_admin_action('config') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	load_language($core, 'config');
	$config = &$core->CONFIG;
	include template($this_system, 'config/aboutlogin','admin');
	
}else if(REQUEST_METHOD == 'POST'){
	$config = isset($_POST['config']) && is_array($_POST['config']) ? $_POST['config'] : array();
    $core->set_config($config);
	message('done',$this_url);
}
