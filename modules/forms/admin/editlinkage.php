<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action('field') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	$action = isset($_GET['action'])? $_GET['action'] : 'add';
	$mid = isset($_GET['mid'])? intval($_GET['mid']) : '';
	$fid = isset($_GET['fid'])? intval($_GET['fid']) : '';
	$iid = isset($_GET['iid'])? $_GET['iid'] : '';
	$this_module->set_model($mid) or message('no_such_model');
	$data = array();
	$data = $this_module->get_field($fid);
	$path = explode('-',$iid);
	$l = $iid? count($path) : 0;
	$select = mb_unserialize($data['data']);
	$select_data = $this_controller->get_select_data($select['select_data'], $iid);
	$pid = substr($iid,0,strrpos($iid,'-'));
	include template($this_module, 'edit_linkage', 'admin');

}else if(REQUEST_METHOD == 'POST'){
	$action = isset($_POST['action'])? $_POST['action'] : 'update';
	$mid = isset($_POST['mid'])? intval($_POST['mid']) : '';
	$this_module->set_model($mid) or message('no_such_model');
	if($action == 'update'){
		$fid = isset($_POST['fid'])? intval($_POST['fid']) : '';
		$iid = isset($_POST['iid'])? $_POST['iid'] : '';
		$fid or message('no_such_item');
		$this_controller->update_linkage($_POST);
	}
	elseif($action == 'delete'){
		$fid = isset($_POST['fid'])? intval($_POST['fid']) : '';
		$iid = isset($_POST['iid'])? intval($_POST['iid']) : '';
		$fid or message('no_such_item');
		$status = $this_controller->delete_linkage_item($_POST);
		echo json_encode($status);
		exit;
	}
		
	message('done',$this_url.'?mid='.$mid.'&fid='.$fid.'&iid='.$iid);	
}