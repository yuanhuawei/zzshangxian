<?php
defined('PHP168_PATH') or die();

/**
* 审核文章,只提供AJAX调用
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? filter_int($_POST['id']) : array();
	$value = isset($_POST['value']) ? intval($_POST['value']) : 0;
	
	//$this_controller->verify_acl($value);
	
	$id or exit('[]');
	
	$verified = isset($_POST['verified']) && $_POST['verified'] == 1 ? true : false;
	//退稿理由
	$push_back_reason = isset($_POST['push_back_reason']) ? html_entities(from_utf8($_POST['push_back_reason'])) : '';
	
	$T = $value == 1 ? $this_module->unverified_table : $this_module->main_table;
	$T = $verified ? $this_module->main_table : $this_module->unverified_table;
	
	$cond = $T .'.id IN ('. implode(',', $id) .')';
	
	$ret = $this_controller->verify(array(
		'where' => $cond,
		'value' => $value,
		'verified' => $verified,
		'push_back_reason' => $push_back_reason
	));
	
	exit(jsonencode($ret));
}
exit('[]');