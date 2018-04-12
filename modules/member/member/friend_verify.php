<?php
defined('PHP168_PATH') or die();

/**
* 验证或拒绝好友
**/

if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? filter_int($_POST['id']) : array();
	$value = empty($_POST['value']) ? 0 : 1;
	
	$reason = isset($_POST['reason']) ? html_entities($_POST['reason']) : '';
	
	$this_module->verify_friend($id, $value, $reason);
	
	exit(jsonencode($id));
}