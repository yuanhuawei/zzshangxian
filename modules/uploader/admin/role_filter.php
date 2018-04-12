<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$role_id = isset($_GET['role_id']) ? $_GET['role_id'] : 0;
	
	$role = &$core->load_module('role');
	if($role_id){
		$role->get_cache();
		
		
		if(empty($role->roles[$role_id]))
			message('no_such_item');
		
		$config = $core->get_config('core', 'uploader');
		$role_filters = empty($config['role_filters']) ? array() : $config['role_filters'];
		$filter = isset($role_filters[$role_id]['filter']) ? $role_filters[$role_id]['filter'] : array();
		
		foreach($filter as $ext => $size){
			$filter[$ext] = $size / 1024;
		}
		$enabled = !empty($role_filters[$role_id]['enabled']);
		
		include template($this_module, 'role_filter', 'admin');
	}else{
		
		$systems = &$core->systems;
		$system = isset($_GET['system']) ? $_GET['system'] : 'core';

		load_language($core, 'config');
		load_language($role, 'global');
		$role->get_cache();

		$system_list = &$core->systems;

		$list = $role->get_by_system(empty($core->CONFIG['use_core_roles_only']) ? $system : 'core');
		
		include template($this_module, 'role_list', 'admin');
	}

}else if(REQUEST_METHOD == 'POST'){
	
	$enabled = empty($_POST['enabled']) ? false : true;
	$role_id = isset($_POST['role_id']) ? $_POST['role_id'] : 0;
	
	$role_id or message('no_such_item');
	
	$config = $core->get_config('core', 'uploader');
	$ext = isset($_POST['filter']['ext']) ? (array)$_POST['filter']['ext'] : array();
	$size = isset($_POST['filter']['size']) ? (array)$_POST['filter']['size'] : array();
	
	$filter = array();
	foreach($ext as $k => $v){
		$_ext = trim($v);
		if(empty($_ext)) continue;
		if(in_array(strtolower($_ext),$this_module->deny))message('file_type_deny');;
		
		$_size = intval($size[$k]);
		if(empty($_size)) continue;
		
		$filter[$_ext] = $_size * 1024;
	}
	
	$role_filters = empty($config['role_filters']) ? array() : $config['role_filters'];
	$role_filters[$role_id] = array(
		'enabled' => $enabled,
		'filter' => $filter,
	);
	
	$this_module->set_config(
		array(
			'role_filters' => $role_filters
		)
	);
	
	message('done');
}