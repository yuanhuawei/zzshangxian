<?php
defined('PHP168_PATH') or die();

/**
* 添加一个积分规则
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$system = $data['system'] = isset($_GET['system']) ? $_GET['system'] : '';
	$module = $data['module'] = isset($_GET['module']) ? $_GET['module'] : '';
	$type = isset($_GET['type']) ? $_GET['type'] : '';
	$postfix = $data['postfix'] = isset($_GET['postfix']) ? $_GET['postfix'] : '';
	
	$systems = &$core->systems;
	
	load_language($core, 'config');
	
	$select = select();
	$select->from($this_module->table, '*');
	
	$role = &$core->load_module('role');
	
	$credits = $core->list_item($select);
	
	$role->get_cache();
	$role_json = jsonencode($role->system_roles);
	
	include template($this_module, 'rule_edit', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$this_controller->add_rule($_POST);
	
	message('done');
}