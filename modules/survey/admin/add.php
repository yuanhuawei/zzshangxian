<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action('item') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	$action = isset($_GET['action'])? $_GET['action'] : 'add';
	
	$template_dir = !empty($this_module->CONFIG['template'])? $this_module->CONFIG['template'].'/core/' : 'default/core/';
	$template_dir .= $this_module->name.'/';
	include template($this_module, 'edit', 'admin');

}else if(REQUEST_METHOD == 'POST'){

	$this_controller->add_item($_POST);
	message('done',$this_router.'-item');	
}