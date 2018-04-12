<?php
defined('PHP168_PATH') or die();

/**
* 支付接口开关,只提供AJAX提交
**/

$this_controller->check_admin_action($ACTION) or exit('0');

if(REQUEST_METHOD == 'POST'){
	
	$interface = isset($_POST['name']) ? basename($_POST['name']) : '';
	$enabled = empty($_POST['enabled']) ? 0 : 1;
	
	$this_module->enable_interface($interface, $enabled) or exit('0');
	
	exit('1');
	
}