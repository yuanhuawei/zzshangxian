<?php
defined('PHP168_PATH') or die();

/**
* 设置权限
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');
$MODEL = '';

if(REQUEST_METHOD == 'GET'){

	$role_id = isset($_GET['role_id']) ? intval($_GET['role_id']) : 0;
	$role_id or message('no_such_item');
	$category = &$this_system->load_module('category');
	//$category->get_cache();
	$json = $category->get_json();
	$role = &$core->load_module('role');
	//$role->get_cache(true);
	$acls = $role->get_acl($this_module, $role_id);
	$info = include $this_module->path .'#.php';
	
	unset($info['actions']['my_list'], $info['actions']['search'], $info['actions']['comment']);
	
	include template($this_module, 'set_acl', 'admin');
}else if(REQUEST_METHOD == 'POST'){
	
	$role_id = isset($_POST['role_id']) ? intval($_POST['role_id']) : 0;
	$role_id or message('no_such_item');
	
	$acl = isset($_POST['acl']) && is_array($_POST['acl']) ? $_POST['acl'] : array();
	$acl['category_acl'] = isset($acl['category_acl']) && is_array($acl['category_acl']) ? $acl['category_acl'] : array();
	
	//本角色可以审核的栏目
	$my_category_to_verify = array();
	//我可以添加内容的栏目
	$my_addible_category = array();
	
	foreach($acl['category_acl'] as $cid => $a){
		if(!empty($a['actions']['verify'])){
			$my_category_to_verify[$cid] = $cid;
		}
		if(!empty($a['actions']['add'])){
			$my_addible_category[$cid] = $cid;
		}
		
		if(!empty($a['actions'])){
			foreach($a['actions'] as $act => $v){
				//强转bool型
				$acl['category_acl'][$cid]['actions'][$act] = (bool) $v;
			}
		}
	}
	$acl['my_category_to_verify'] = $my_category_to_verify;
	$acl['my_addible_category'] = $my_addible_category;
	
	$role = &$core->load_module('role');
	$controller = &$core->controller($role);
	
	$controller->set_acl($this_module, $role_id, $acl);
	
	message('done');
}