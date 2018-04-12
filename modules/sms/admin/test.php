<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){

	$list = $this_module->interfaces;
	
	include template($this_module, 'test', 'admin');

}else if(REQUEST_METHOD == 'POST'){
	
	$_POST = p8_stripslashes2($_POST);
	
	$send_to = isset($_POST['send_to']) ? $_POST['send_to'] : '';
	$message = isset($_POST['message']) ? $_POST['message'] : '';
	$interface = isset($_POST['interface']) ? $_POST['interface'] : '';
	
	if($interface == ''){
		message('select_interface');
	}
	
	$status=$this_module->send($send_to, $message, $interface) or message('fail');
	message($status);
}