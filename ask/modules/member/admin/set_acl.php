<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){

	load_language($this_system, 'admin');

	$role_id = isset($_GET['role_id']) ? intval($_GET['role_id']) : 0;
	
	$role = &$core->load_module('role');
	if($role_id){
		$acl = $role->get_acl($this_module, $role_id);
		$info = include $this_module->path .'#.php';
		
		include template($this_module, 'set_acl', 'admin');
		
	}else{
		$acl_module = $this_module->name;
		$acl_module = '';
		$role->get_cache();
		
		$list = $role->get_by_system(empty($core->CONFIG['use_core_roles_only']) ? $this_module->name : 'core');
		
		include template($role, 'list', 'admin');
	}
	
}else if(REQUEST_METHOD == 'POST'){
	
	$acl = empty($_POST['acl']) ? array() : $_POST['acl'];
	$role_id = $_POST['role_id'];
	
	$role = &$core->load_module('role');
	$controller = &$core->controller($role);
	$controller->set_acl($this_module, $role_id, $acl);

	message('done', $this_url);
	
}