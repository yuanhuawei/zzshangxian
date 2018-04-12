<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$id = $_GET['id'] ? intval($_GET['id']) : 0;
	$id or message('no_such_item');
	
	load_language($this_module, 'config');
	
	$role = &$core->load_module('role');
	$role->get_cache();
	
	$roles = array();
	$tmp = $DB_master->fetch_one("SELECT role_id FROM ". $core->TABLE_ ."member WHERE id = '$id'");
	$roles['core'] = empty($tmp) ? 0 : $tmp['role_id'];
	/* 
	foreach($core->systems as $system => $v){
		$tmp = $DB_master->fetch_one("SELECT role_id FROM ". P8_TABLE_ ."{$system}_member WHERE id = '$id'");
		$roles[$system] = empty($tmp) ? 0 : $tmp['role_id'];
	} */
	
	include template($this_module, 'set_roles', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$roles = isset($_POST['role']) && is_array($_POST['role']) ? $_POST['role'] : array();
	
	$this_module->set_role($id, $role_id);
	
	message('done');
}