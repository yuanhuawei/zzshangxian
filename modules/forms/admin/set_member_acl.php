<?php
defined('PHP168_PATH') or die();

/**
* 设置权限
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');
$MODEL = '';

if(REQUEST_METHOD == 'GET'){

	$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
	
	$member = &$core->load_module('member');
	
	$info = include $this_module->path .'#.php';
	$this_module->cache();
	$models  = $this_module->core->CACHE->read('core/modules', 'forms', 'models');

	$acls = $member->get_acl($this_module, $user_id);
	
	include template($this_module, 'set_member_acl', 'admin');

}else if(REQUEST_METHOD == 'POST'){
	
	$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
	$user_id or message('no_such_item');
	
	$acl = isset($_POST['acl']) ? (array)$_POST['acl'] : array();
	$acl['category_acl'] = isset($acl['category_acl']) ? (array)$acl['category_acl'] : array();
	$my_forms_post = $my_forms_manage = array();
	foreach($acl['category_acl'] as $cid => $a){
		if(!empty($a['actions']['manage'])){
			$my_forms_manage[$cid] = 1;
		}
		if(!empty($a['actions']['post'])){
			$my_forms_post[$cid] = 1;
		}
		
		if(!empty($a['actions'])){
			foreach($a['actions'] as $act => $v){
				//强转bool型
				$acl['category_acl'][$cid]['actions'][$act] = (bool) $v;
			}
		}
	}
	$acl['my_forms_manage'] = $my_forms_manage;
	$acl['my_forms_post'] = $my_forms_post;
	$member = &$core->load_module('member');
	$controller = &$core->controller($member);
	$controller->set_acl($this_module, $user_id, $acl);
	
	message('done');
}