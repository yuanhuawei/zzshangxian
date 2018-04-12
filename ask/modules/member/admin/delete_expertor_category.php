<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(!P8_AJAX_REQUEST || REQUEST_METHOD == 'GET' || empty($_POST['uids']) || empty($_POST['ids'])){
	die();
}

$json = $this_controller->delete_expertor(array('uids'=>$_POST['uids'],'ids'=>$_POST['ids'])) or die();
echo jsonencode($json);
exit;