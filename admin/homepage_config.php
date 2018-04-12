<?php
defined('PHP168_PATH') or die();

/**
* ÐÞ¸ÄºËÐÄÅäÖÃ
**/

$this_controller->check_admin_action('config') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	load_language($core, 'config');

	$config = $core->get_config('core', '');
	$config = isset($config['homepage']) ? (array)$config['homepage'] : array();
	
	include template($core, 'config/homepage_config', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$_POST = p8_stripslashes2($_POST);
	
	$config = isset($_POST['config']) && is_array($_POST['config']) ? $_POST['config'] : array();
	
	$core->set_config(array('homepage' => $config));
	
	message('done');
}