<?php
defined('PHP168_PATH') or die();

/**
* 我管理的表单
**/

if(REQUEST_METHOD == 'POST'){
	$action =  isset($_POST['action'])? $_POST['action'] : '';
	
	if($action == 'check_status'){
		$id =  isset($_POST['id']) ? intval($_POST['id']) : '';
		$data = $this_module->DB_master->fetch_one("SELECT id, status,recommend, reply FROM $this_module->table WHERE id = '$id'");
		exit(p8_json($data));
	}else
	if($action == 'set_status'){
		$id =  isset($_POST['id']) ? filter_int($_POST['id']) : array();
		$oid = isset($_POST['oid']) ? intval($_POST['oid']) : '';
		$status = isset($_POST['status']) ? intval($_POST['status']) : '';
		$reply = isset($_POST['reply']) ? from_utf8(p8_html_filter($_POST['reply'])) : '';
		if(!$id && !$oid )exit('[]');
		$realarray = $oid? array($oid) : $id;
		$recommend = isset($_POST['recommend']) ? intval($_POST['recommend']) : '';
		
		$resule = $this_module->status(array(
			'ids' => implode(",",$realarray),
			'reply' => $reply,
			'status' => $status,
			'recommend' => $recommend,
			'replyer' => $USERNAME
		));
		
		
		exit(p8_json($resule));
		
	}else
	if($action == 'delete'){
		$id =  isset($_POST['id']) ? filter_int($_POST['id']) : array();
		$oid = isset($_POST['oid']) ? intval($_POST['oid']) : '';
		$mid = isset($_POST['mid']) ? intval($_POST['mid']) : '';
		if(!$id && !$oid || !$mid)exit('[]');
		$this_module->set_model($mid);
		$realarray = $oid? array($oid) : $id;
		
		$resule = $this_module->delete(array('ids' => $realarray));
		
		
		exit(p8_json($resule));
		
	}
	
	


}