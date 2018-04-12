<?php
defined('PHP168_PATH') or die();

/**
* 设置当前系统及所属模块的管理员权限开关
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){

	$role_id = isset($_GET['role_id']) ? intval($_GET['role_id']) : 0;
	
	$role = &$core->load_module('role');
	
	if($role_id){
		$acl = $role->get_acl($this_system, $role_id);
		$info = include $this_system->path .'#.php';
		
		//各模块的权限
		$acls = array();
		//各模块的描述
		$infos = array();
		foreach($this_system->modules as $name => $v){
			$m = &$this_system->load_module($name);
			$acls[$name] = $role->get_acl($m, $role_id);
			
			$infos[$name] = include $m->path .'#.php';
		}
		
		include template($core, 'system_admin_acl', 'admin');
		
	}else{
		
		$acl_system = $this_system->name;
		$acl_module = '';
		$role->get_cache();
		
		$list = $role->get_by_group($core->CONFIG['administrator_role_group'], !empty($core->CONFIG['use_core_roles_only']) ? 'core' : $this_system->name);
		
		include template($role, 'list', 'admin');
	}
	
}else if(REQUEST_METHOD == 'POST'){
	
	$acl = isset($_POST['acl']) && is_array($_POST['acl']) ? $_POST['acl'] : array();
	$acls = isset($_POST['acls']) && is_array($_POST['acls']) ? $_POST['acls'] : array();
	$role_id = isset($_POST['role_id']) ? intval($_POST['role_id']) : 0;
	
	$role = &$core->load_module('role');
	$controller = &$core->controller($role);
	
	//设置核心的权限
	$controller->set_acl($this_system, $role_id, $acl);
	
	foreach($acls as $module => $acl){
		//设置各模块的权限
		$m = &$this_system->load_module($module);
		$controller->set_acl($m, $role_id, $acl);
	}
	
	//菜单权限
	$role->set_menu_privilege($role_id);
	
	message('done', HTTP_REFERER);
}