<?php
defined('PHP168_PATH') or die();

/**
* 删除追加内容, 只能由ajax请求, 如果成功则返回被删除的页数
**/

$this_controller->check_admin_action('delete') or message('[]');

if(REQUEST_METHOD == 'POST'){
	
	$model = isset($_POST['model']) ? $_POST['model'] : '';
	
	$iid = isset($_POST['iid']) ? intval($_POST['iid']) : 0;
	$iid or exit('[]');
	
	$id = isset($_POST['id']) ? filter_int((array)$_POST['id']) : array();
	$__id__ = $id;
	$verified = isset($_POST['verified']) && $_POST['verified'] == 1 ? true : false;
	
	$this_controller->delete_addon(array(
		'iid' => $iid,
		'id' => $id,
		'verified' => $verified
	));
	
	exit(jsonencode($__id__));
}