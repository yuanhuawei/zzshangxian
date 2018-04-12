<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$list = $this_module->interfaces;
	
	include template($this_module, 'list_interface', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	define('NO_ADMIN_LOG', true);
	
	$this_module->list_interface(true);
	
	message('done');
}