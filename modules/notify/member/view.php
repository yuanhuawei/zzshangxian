<?php
defined('PHP168_PATH') or die();
/**
*²é¿´
**/

//$this_controller->check_action($ACTION) or message('no_privilege');
if(REQUEST_METHOD == 'GET'){

	$id = isset($_GET['id']) ? intval($_GET['id']) : '';

	$data = $core->DB_master->fetch_one("SELECT n.id, n.title, n.username, n.timestamp, n.content, i.uid, i.comment, i.status, i.hash FROM {$this_module->table} as n INNER JOIN {$this_module->sign_in_table} as i ON n.id=i.nid WHERE n.id = '$id' AND i.uid=$UID");
	if(empty($data) && $this_controller->check_action('edit')){
			$data = $this_module->view($id);
		}
	//$username = $member
	if(empty($data))message('no_such_item');
	$core->DB_slave->update($this_module->sign_in_table,array('receive' => 1),"nid = '$id' AND uid = '$UID'");
	include template($this_module,'view');
	print_r($core->member);
}else if(REQUEST_METHOD=='POST'){
		//$this_controller->check_action('show&sign') or message($P8LANG['no_privilege']);
		$id = isset($_POST['id']) ? intval($_POST['id']) : '';
		if(empty($id))message('err');
		$hash = isset($_POST['hash']) ? $_POST['hash'] : '';
		$status = isset($_POST['status']) ? intval($_POST['status']) : '';
		$comment = isset($_POST['comment'])? p8_html_filter($_POST['comment']) : '';
		$data=array(
			'id' => $id,
			'uid' => $UID,
			'status' => $status,
			'hash' => $hash,
			'comment' => $comment
		);
		$this_module->sign_in(&$data) or exit('[]');
		$returndata['status']=$status;
		message('done','close');
}	