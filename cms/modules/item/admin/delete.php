<?php
defined('PHP168_PATH') or die();

/**
* 删除, 只提供AJAX
**/

$this_controller->check_admin_action($ACTION) or exit('[]');

if(REQUEST_METHOD == 'POST'){
	//过滤非数字
	$id = isset($_POST['id']) ? filter_int($_POST['id']) : array();
	$id or exit('[]');
	
	$verified = isset($_POST['verified']) && $_POST['verified'] == 1 ? true : false;
	
	$T = $verified ? $this_module->main_table : $this_module->unverified_table;
	
	$ret = $this_controller->delete(array(
		'where' => $T .'.id IN ('. implode(',', $id) .')',
		'verified' => $verified,
		'delete_hook' => false,
		'iid' => $id
	));
	
	exit(jsonencode($ret));
}
exit('[]');