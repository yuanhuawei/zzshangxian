<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or exit('0');

if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	
	if(in_array($id, array($core->CONFIG['guest_role'], $core->CONFIG['member_role'], $core->CONFIG['administrator_role']))){
		//游客,会员,管理员角色不能删除
		exit('0');
	}
	
	if($this_module->delete($id)){
		$this_module->cache();
		exit('1');
	}
	
	exit('0');
}