<?php
defined('PHP168_PATH') or die();

/**
* 修改会员积分
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	$id or message('no_such_item');
	
	$core->get_cache('credit');
	$credit = $core->get_credit($id);
	
	include template($this_module, 'credit', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$id or message('no_such_item');
	
	$credit = isset($_POST['credit']) ? (array)$_POST['credit'] : array();
	$credit or message('no_such_item');
	
	$credits = array();
	foreach($credit as $cid => $v){
		$cid = intval($cid);
		$v = intval($v);
		if(!$cid) continue;
		
		$credits[$cid] = intval($v);
	}
	
	$core->update_credit($id, $credits, false);
	
	message('done', HTTP_REFERER);
}