<?php
defined('PHP168_PATH') or die();


if(REQUEST_METHOD == 'GET'){
	
	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	$id or message('no_such_item');
	
	$data = $DB_master->fetch_one("SELECT username, role_gid FROM $this_module->table WHERE id = '$id'");
	$data or message('no_such_item');
	
	$data = get_member($data['username']);
	
	//$role_gid = isset($_GET['role_gid']) ? intval($_GET['role_gid']) : 0;
	
	$this_module->set_model($data['role_gid']);
	$this_model = &$this_module->get_model($data['role_gid']);
	
	
	$core->get_cache('role_group');
	$roles = $core->get_cache('role');
	unset($roles[$core->CONFIG['guest_role']]);
	
	/*$select = select();
	$select->from($this_module->table .' AS m', 'm.*');
	$select->inner_join($this_module->addon_table .' AS a', 'a.*', 'm.id = a.id');
	$select->in('m.id', $id);
	$data = $core->select($select, array('single' => true, 'ms' => 'master'));*/
	
	$this_module->format_data($data);
	
	include template($this_module, 'view', 'admin');
	
}