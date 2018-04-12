<?php
defined('PHP168_PATH') or die();

if(!P8_AJAX_REQUEST || REQUEST_METHOD == 'GET'){
	die();
}

$json = $this_controller->delete_expertor(array('uids'=>$_POST['uids'])) or die();
echo jsonencode($json);
exit;