<?php
defined('PHP168_PATH') or die();

/**
* ���һ����������
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$systems = &$core->systems;
	
	load_language($core, 'config');
	
	$core->get_cache('credit');
	
	include template($this_module, 'edit', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$this_controller->add($_POST);
	
	message('done');
}