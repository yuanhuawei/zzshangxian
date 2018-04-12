<?php
defined('PHP168_PATH') or die();

/**
* 修改会员资料
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	$id or message('no_such_item');
	
	$role_gid = isset($_GET['role_gid']) ? intval($_GET['role_gid']) : 0;
	
	$this_module->set_model($role_gid);
	$this_model = &$this_module->get_model($role_gid);
	
	
	$core->get_cache('role_group');
	$roles = $core->get_cache('role', 'all');
	unset($roles[$core->CONFIG['guest_role']]);
	
	$role_group_json = jsonencode($core->role_groups);
	$role_json = jsonencode($roles);
	
	$select = select();
	$select->from($this_module->table .' AS m', 'm.*');
	$select->inner_join($this_module->addon_table .' AS a', 'a.*', 'm.id = a.id');
	$select->in('m.id', $id);
	$data = $core->select($select, array('single' => true, 'ms' => 'master'));
	
	$this_module->format_data($data);
	
	include template($this_module, 'edit', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$id or message('no_such_item');
	
	$role_gid = isset($_POST['role_gid']) ? intval($_POST['role_gid']) : 0;
	$role_id = isset($_POST['role_id']) ? intval($_POST['role_id']) : 0;
	
	$this_module->set_model($role_gid);
	$this_model = &$this_module->get_model($role_gid);
	
	$this_controller->update($id, $_POST);
	
	message('done', $this_router .'-list');
}