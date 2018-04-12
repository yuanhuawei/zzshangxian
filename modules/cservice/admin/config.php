<?php
defined('PHP168_PATH') or die();
$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD=='GET'){
$config = $core->get_config($this_system->name, $this_module->name);

include template($this_module,'config',admin);

}else if(REQUEST_METHOD=='POST'){
	
	$_POST = p8_stripslashes2($_POST);
	
	$config = isset($_POST['config']) && is_array($_POST['config']) ? $_POST['config'] : array();
	foreach($config['cs_category'] as $k => $v){
		if(empty($v))unset($config['cs_category'][$k]);
	}

	$this_module->set_config($config);
	message('done',$this_url);
}