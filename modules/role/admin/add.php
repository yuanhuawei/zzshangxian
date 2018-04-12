<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$systems = &$core->systems;
	
	$this_module->get_group_cache();
	
	include template($this_module, 'edit', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$this_controller->add($_POST);
	
	$this_module->cache_role();
	
	message('done', $this_router .'-list');
}