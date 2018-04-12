<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or die();

P8_AJAX_REQUEST or die();

if(REQUEST_METHOD == 'POST'){
	
	$json = $this_controller->set_star($_POST) or die();
	echo jsonencode($json);

}
exit;