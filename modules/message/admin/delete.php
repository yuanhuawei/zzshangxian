<?php
defined('PHP168_PATH') or die();

/**
* 删除短消息,只提供AJAX调用
**/

$this_controller->check_admin_action($ACTION) or exit('[]');

if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? filter_int($_POST['id']) : array();
	$id or exit('[]');
	
	$this_module->delete(array(
		'where' => 'id IN ('. implode(',', $id) .')'
	)) or exit('[]');
	
	exit(jsonencode($id));
}