<?php
defined('PHP168_PATH') or die();

/**
* 设置系统及系统下属所有模块的权限开关
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){

	$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
	
	$member = &$core->load_module('member');
	
	if($user_id){
		//本系统的权限
		$acl = $member->get_acl($this_system, $user_id);
		$info = include $this_system->path .'#.php';
		
		//各模块的权限
		$acls = array();
		//各模块的描述
		$infos = array();
		foreach($this_system->modules as $name => $v){
			//各模块的权限
			$m = &$this_system->load_module($name);
			$acls[$name] = $member->get_acl($m, $user_id);
			
			$infos[$name] = include $m->path .'#.php';
		}
		
		include template($core, 'system_member_acl', 'admin');
		
	}else{
		
		$acl_system = $this_system->name;
		$acl_module = '';
		$member->get_cache();
		
		$list = $member->get_by_system('core');
		
		include template($member, 'list', 'admin');
	}
	
}else if(REQUEST_METHOD == 'POST'){
	
	$acl = isset($_POST['acl']) && is_array($_POST['acl']) ? $_POST['acl'] : array();
	$acls = isset($_POST['acls']) && is_array($_POST['acls']) ? $_POST['acls'] : array();
	$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
	
	$member = &$core->load_module('member');
	$controller = &$core->controller($member);
	
	//设置系统的权限
	$controller->set_acl($this_system, $user_id, $acl);
	
	foreach($acls as $module => $acl){
		//设置各模块的权限
		$m = &$this_system->load_module($module);
		$controller->set_acl($m, $user_id, $acl);
	}
	
	$member->set_menu_privilege($user_id);
	
	message('done', HTTP_REFERER);
}