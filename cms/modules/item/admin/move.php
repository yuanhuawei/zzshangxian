<?php
defined('PHP168_PATH') or die();

/**
* 移动内容,只提供AJAX POST调用
**/

$this_controller->check_admin_action($ACTION) or exit('[]');

if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? filter_int($_POST['id']) : array();
	$id or exit('[]');
	
	$cid = isset($_POST['cid']) ? intval($_POST['cid']) : 0;
	$cid or exit('[]');
	$__id__ = $id;
	
	if(isset($_POST['verified'])){
		$verified = $_POST['verified'] == 1 ? true : false;
	}else{
		$verified = true;
	}
	
	$this_module->move($id, $cid, $verified) or exit('[]');
	
	exit(p8_json($__id__));
	
}