<?php
defined('PHP168_PATH') or die();

//$this_controller->check_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	include template($this_module, 'passwd');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$old = isset($_POST['old_password']) ? $_POST['old_password'] : '';
	$new = isset($_POST['new_password']) ? $_POST['new_password'] : '';
	$confirm = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
	
	switch($s = $this_controller->change_password($USERNAME, $old, $new, $confirm)){
		case 0:
			message('done');
		break;
		
		case -1:
			message('password_not_match');
		break;
		
		case -2:
			message('input_old_password');
		break;
	}
	echo $s;
}