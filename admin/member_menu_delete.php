<?php
defined('PHP168_PATH') or die();

/**
* ɾ����Ա���Ĳ˵�
**/

$this_controller->check_admin_action('member_menu') or message('no_privilege');

//ֻ�ṩAJAX��ʽ����,û�н���

if(REQUEST_METHOD == 'POST'){
	
	require_once PHP168_PATH .'/modules/member/inc/menu.class.php';
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	
	$member_menu->get_cache();
	
	$json = $member_menu->delete($id);
	
	echo jsonencode($json);
}
exit;