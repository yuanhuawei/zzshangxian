<?php
defined('PHP168_PATH') or die();

$this_system->init_model();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? $_POST['id'] : 0;
	
	$role = &$core->load_module('role');
	
	$role->delete_acl(
		array(
			'system' => $this_system->name,
			'module' => $this_module->name,
			'postfix' => 'category_'. $id
		)
	) or message('fail');
	
	message('done');
}