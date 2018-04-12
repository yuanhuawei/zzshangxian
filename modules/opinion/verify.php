<?php
defined('PHP168_PATH') or die();

$this_controller->check_action('manage') or message($P8LANG['no_privilege']);

if(REQUEST_METHOD == 'GET'){

}elseif(REQUEST_METHOD == 'POST'){

	$id = intval($_POST['id']);
	$act = $_POST['act'];
	if($act=='verify'){
		$status = intval($_POST['status']);
		$ret = $this_module->verify($id,$status);
	}elseif($act=='accept'){
		$accept = html_entities(from_utf8(($_POST['accept'])));
		$ret = $this_module->accept($id,$accept);
	}
	echo p8_json($ret);
	exit;

}