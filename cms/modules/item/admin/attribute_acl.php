<?php
defined('PHP168_PATH') or die();

/**
* 内容属性权限设置
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$config = $core->get_config($SYSTEM, $MODULE);
	$config = isset($this_module->CONFIG['attribute_acl']) ? $this_module->CONFIG['attribute_acl'] : array();
	$Role = $core->load_module('role');
	$Role->cache_role();
	$roles = $Role->roles;

	$role_json = p8_json($roles);
	$acl_json = p8_json($config);
	
	include template($this_module, 'attribute_acl', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$_acl = isset($_POST['attribute_acl']) && is_array($_POST['attribute_acl']) ? $_POST['attribute_acl'] : array();
	
	$acl = array();
	foreach($_acl as $aid => $roles){
		foreach((array)$roles as $rid => $v){
			$acl[$aid][$rid] = 1;
		}
	}
	
	$this_module->set_config(array('attribute_acl' => $acl));
	
	message('done');
}