<?php
defined('PHP168_PATH') or die();

/**
* 删除附件,只提供AJAX调用
**/

$this_controller->check_admin_action($ACTION) or exit('[]');

if(REQUEST_METHOD == 'POST'){
	$id = isset($_POST['id']) ? filter_int($_POST['id']) : array();
	$id or exit('[]');
	
	$system = isset($_POST['system']) ? $_POST['system'] : '';
	//系统不存在
	if($system != 'core' && !get_system($system)) exit('[]');
	
	$this_module->set($system);
	
	$this_module->delete(array(
		'where' => 'id IN ('. implode(',', $id) .')'
	)) or exit('[]');
	
	exit(jsonencode($id));
}
exit('[]');