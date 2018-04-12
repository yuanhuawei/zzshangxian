<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	load_language($core, 'config');
	$json = $this_module->get_json();

	include template($this_module, 'list', 'admin');

}else if(REQUEST_METHOD == 'POST'){

	message('done');

}