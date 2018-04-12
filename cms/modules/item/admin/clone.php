<?php
defined('PHP168_PATH') or die();

/**
* 移动内容,只提供AJAX POST调用
**/

$this_controller->check_admin_action($ACTION) or exit('[]');

if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['sourceid']) ? filter_int($_POST['sourceid']) : array();
	$id or exit('[]');
	
	$cid = isset($_POST['cid']) ? $_POST['cid'] : '';
	$cid or exit('[]');
	$__id__ = $id;
	
	$clone_type = intval($_POST['clone_type']);
	$clone_time = $clone_type?$_POST['clone_time']:0;
	
	if(isset($_POST['verified'])){
		$verified = $_POST['verified'] == 1 ? true : false;
	}else{
		$verified = true;
	}
	$cids = explode(',',$cid);
	$cids = array_filter($cids);
    define('P8_CLUSTER',true);
	foreach($cids as $_cid){
		$this_module->cloneitem($id, $_cid, $verified,$clone_time) or exit('[]');
	}
	
	exit(p8_json($__id__));
	
}