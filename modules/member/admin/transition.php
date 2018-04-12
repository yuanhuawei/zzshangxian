<?php
defined('PHP168_PATH') or die();

/**
* »áÔ±×ª»»
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	$integration_type = $_GET['type'];
	include $this_module->path .'call/transition.'.$integration_type.'.php';
}else if(REQUEST_METHOD == 'POST'){
	$integration_type = $_POST['config']['integration_type'];
	include $this_module->path .'call/transition.'.$integration_type.'.php';
}