<?php
defined('PHP168_PATH') or die();
/**
* ɾ�������˵�
**/
$this_controller->check_admin_action('navigation_menu') or message('no_privilege');
//ֻ�ṩAJAX��ʽ����,û�н���
if(REQUEST_METHOD == 'POST'){	
	require_once PHP168_PATH .'admin/inc/navigation_menu.class.php';	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;	
	$navigation_menu->get_cache();	
	$json = $navigation_menu->delete($id);	
	echo jsonencode($json);
}
exit;