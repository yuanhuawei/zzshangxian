<?php
defined('PHP168_PATH') or die();

/**
* Ä£¿éÅäÖÃ
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){

	$config = $core->get_config('core', 'interview');
	$info = include $this_module->path .'#.php';
	//$config = array_merge($info, $core->CONFIG, $config);
	
	include template($this_module, 'config', 'admin');

}else if(REQUEST_METHOD == 'POST'){
	
	$_POST = p8_stripslashes2($_POST);
	
	$config = isset($_POST['config']) && is_array($_POST['config']) ? $_POST['config'] : array();
	
	$this_module->set_config($config);
	
	message('done');
}