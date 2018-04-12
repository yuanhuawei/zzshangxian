<?php
defined('PHP168_PATH') or die();

/**
* 删除会员, 只能由AJAX请求, 成功返回被删除的ID
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');


if(REQUEST_METHOD == 'POST'){
	$id = isset($_POST['id']) ? filter_int($_POST['id']) : array();
	$id or exit('[]');
	
	$this_module->delete(array(
		'where' => $this_module->table .'.id IN ('. implode(',', $id) .')'
	)) or exit('[]');
/**
* your code
**/
	exit(jsonencode($id));
}