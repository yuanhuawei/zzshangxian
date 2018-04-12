<?php
defined('PHP168_PATH') or die();
P8_AJAX_REQUEST or die();

//$this_controller->check_action($ACTION) or die();

if(empty($UID)) die();
if(REQUEST_METHOD == 'POST'){
	
	$ids = isset($_POST['ids']) ? $_POST['ids'] : array();
	$json = array();

	if(empty($ids) || !is_array($ids)) die();

	$json = $this_controller->delete_myask($ids);

	echo jsonencode($json);
	exit;

}