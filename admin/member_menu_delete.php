<?php
defined('PHP168_PATH') or die();

/**
* 删除会员中心菜单
**/

$this_controller->check_admin_action('member_menu') or message('no_privilege');

//只提供AJAX方式调用,没有界面

if(REQUEST_METHOD == 'POST'){
	
	require_once PHP168_PATH .'/modules/member/inc/menu.class.php';
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	
	$member_menu->get_cache();
	
	$json = $member_menu->delete($id);
	
	echo jsonencode($json);
}
exit;