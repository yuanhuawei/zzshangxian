<?php
defined('PHP168_PATH') or die();

/**
* ¸´ÖÆÈ¨ÏÞ
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	$id or message('no_such_item');
	
	$this_module->get_cache();
	$src_role = $this_module->roles[$id];
	
	include template($this_module, 'copy_acl', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$id or message('no_such_item');
	
	$target_role = isset($_POST['target_role']) && is_array($_POST['target_role']) ? array_filter(array_map('intval', $_POST['target_role'])) : array();
	if(empty($target_role)) message('select_target_role');
	
	$this_module->copy_acl($id, $target_role) or message('fail');
	
	message('done');
}