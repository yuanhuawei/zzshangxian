<?php
defined('PHP168_PATH') or die();

/**
* �������к���ģ���Ȩ�޿���
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){

	$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

	$member = &$core->load_module('member');
	
	//print_r($this_controller->ACL);
	if($user_id){
		$acl = $member->get_acl($core, $user_id);
		$info = include $core->path .'#.php';
		
		//��ģ���Ȩ��
		$acls = array();
		//��ģ�������
		$infos = array();
		foreach($core->modules as $name => $v){
			$m = &$core->load_module($name);
			if(!file_exists($m->path.'admin/set_member_acl.php'))
			continue;
			$acls[$name] = $member->get_acl($m, $user_id);
			
			$infos[$name] = include $m->path .'#.php';
		}
		include template($core, 'system_member_acl', 'admin');
		
	}else{
		
		$acl_system = 'core';
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
	
	//�༭������,��ֹ�ı�ǩ
	$acl['allow_tags'] = isset($acl['allow_tags']) ? array_filter(explode('|', trim($acl['allow_tags']))) : array();
	$acl['disallow_tags'] = isset($acl['disallow_tags']) ? array_filter(explode('|', trim($acl['disallow_tags']))) : array();
	
	//���ú��ĵ�Ȩ��
	$controller->set_acl($core, $user_id, $acl);
	
	foreach($acls as $module => $acl){
		//���ø�ģ���Ȩ��
		$m = &$core->load_module($module);
		$controller->set_acl($m, $user_id, $acl);
	}
	
	$member->set_menu_privilege($user_id);
	
	message('done', HTTP_REFERER);
}