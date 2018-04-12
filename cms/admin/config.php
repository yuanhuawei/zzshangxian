<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$config = $core->get_config($this_system->name, '');
	load_language($core, 'config');
	
	$info = include $this_system->path. '#.php';
	
	include template($this_system, 'config', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$_POST = p8_stripslashes2($_POST);
	
	$config = isset($_POST['config']) && is_array($_POST['config']) ? $_POST['config'] : array();
	
	if($this_system->CONFIG['template'] != $config['template']){
		//前台模板有修改,通知所有模块修改模板
		foreach($this_system->modules as $mod => $v){
			$module = &$this_system->load_module($mod);
			$module->set_config(array('template' => $config['template']));
		}
	}
	
	$this_system->set_config($config);
	
	message('done');
}