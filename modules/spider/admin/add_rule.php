<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action('rule') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$this_module->get_cache();
	
	include template($this_module, 'rule_edit', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$_POST = p8_stripslashes2($_POST);
	
	$this_controller->add_rule($_POST) or message('fail');
	
	message('done');
}