<?php
defined('PHP168_PATH') or die();

/**
* 修改积分规则
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	
	$data = $this_module->view_rule($id);
	
	$select = select();
	$select->from($this_module->table, '*');
	
	$credits = $core->list_item($select);
	
	$systems = &$core->systems;
	
	load_language($core, 'config');
	
	$role = &$core->load_module('role');
	$role->get_cache();
	$role_json = jsonencode($role->system_roles);
	include template($this_module, 'rule_edit', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	
	$this_controller->update_rule($id, $_POST);
	
	message('done');
}