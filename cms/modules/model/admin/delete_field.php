<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or exit('0');

if(REQUEST_METHOD == 'POST'){
	
	@set_time_limit(0);
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$id or exit('0');
	
	$this_controller->delete_field($id) or exit('0');
	
	exit('1');
}