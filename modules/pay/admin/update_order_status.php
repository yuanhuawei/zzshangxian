<?php
defined('PHP168_PATH') or die();

/**
* 更改订单状态,只提供AJAX调用
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'POST'){
	
	$NO = isset($_POST['NO']) ? $this_controller->valid_NO($_POST['NO']) : '';
	strlen($NO) or exit('');
	
	$status = isset($_POST['status']) ? intval($_POST['status']) : null;
	$status !== null or exit('');
	
	$ret = $this_module->update_order_status($NO, $status);
	$ret !== null or exit('');
	
	exit((string)$status);
}