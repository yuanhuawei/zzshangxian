<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action('menu') or message('no_privilege');

//只提供AJAX方式调用,没有界面

if(REQUEST_METHOD == 'POST'){
	
	require_once PHP168_PATH .'admin/inc/menu.class.php';
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	
	$admin_menu->get_cache();
	
	$json = $admin_menu->delete($id);
	
	echo jsonencode($json);
}
exit;