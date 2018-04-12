<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
$id or message('no_such_item');

$data = $DB_master->fetch_one("SELECT * FROM $this_module->group_field_table WHERE id = '$id'");
$data or message('no_such_item');

if(REQUEST_METHOD == 'GET'){
	
	$widget_data = mb_unserialize($data['data']);
	
	include template($this_module, 'edit_group_field', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$this_controller->update_group_field($id, $_POST);
	
	$this_module->cache_group();
	
	message('done');
}