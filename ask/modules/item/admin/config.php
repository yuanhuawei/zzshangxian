<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){

	load_language($core, 'config');
	load_language($this_system, 'admin');
	
	$config = $core->get_config($this_system->name, $this_module->name);
	
	$info = include $this_module->path. '#.php';	
	
	include template($this_module, 'config', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$_POST = p8_stripslashes2($_POST);
	
	$config = isset($_POST['config']) && is_array($_POST['config']) ? $_POST['config'] : array();
	
	$this_module->set_config($config);
	
	message('done', $this_router."-$ACTION", 3);
}