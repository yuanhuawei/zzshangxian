<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$systems = &$core->systems;
	
	include template($this_module, 'edit_group', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$this_controller->add_group($_POST);
	
	$this_module->cache_group();
	
	message('done', $this_router .'-list_group');
}