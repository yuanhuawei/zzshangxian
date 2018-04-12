<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action('rule') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	$id or message('no_such_item');
	
	$this_module->get_cache();
	
	$data = $this_module->get_rule($id, true);
	$data or message('no_such_item');
	
	include template($this_module, 'rule_edit', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : '';
	
	$_POST = p8_stripslashes2($_POST);
	
	$this_controller->update_rule($id, $_POST);
	
	message('done');
}