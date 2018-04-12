<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	
	//管理组和个人组不能删除
	if(in_array($id, array($core->CONFIG['administrator_role_group'], $core->CONFIG['person_role_group']))){
		exit('0');
	}
	
	if($this_module->delete_group($id)){
		$this_module->cache();
		exit('1');
	}
	
	exit('0');
}