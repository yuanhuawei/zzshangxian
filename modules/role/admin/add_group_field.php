<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

$gid = isset($_REQUEST['gid']) ? intval($_REQUEST['gid']) : 0;
$check = $this_module->view_group($gid);
$check or message('no_such_item');

if(REQUEST_METHOD == 'GET'){
	
	$data['gid'] = $check['id'];
	$widget_data = array();
	
	include template($this_module, 'edit_group_field', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$this_controller->add_group_field($_POST);
	
	$this_module->cache_group();
	
	message('done');
}