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
	$info = include $this_module->path .'#.php';
	$this_module->cache();
	$cates = $this_module->get_category();
	$role = &$core->load_module('role');
	//$role->get_cache(true);
	$acls = $role->get_acl($this_module, $role_id);
	
	include template($this_module, 'set_acl', 'admin');

}else if(REQUEST_METHOD == 'POST'){
	
	$role_id = isset($_POST['role_id']) ? intval($_POST['role_id']) : 0;
	$role_id or message('no_such_item');
	
	$acl = isset($_POST['acl']) ? (array)$_POST['acl'] : array();
	$acl['category_acl'] = isset($acl['category_acl']) ? (array)$acl['category_acl'] : array();
	$my_forms_post = $my_letter_manage = array();
	foreach($acl['category_acl'] as $cid => $a){
	
		if(!empty($a['actions'])){
			foreach($a['actions'] as $act => $v){
				//强转bool型
				$acl['category_acl'][$cid]['actions'][$act] = (bool) $v;
				$my_letter_manage[$act][$cid]=$cid;
			}
		}
	}
	$acl['my_letter_manage'] = $my_letter_manage;
	$role = &$core->load_module('role');
	$controller = &$core->controller($role);
	$controller->set_acl($this_module, $role_id, $acl);
	
	message('done');
}