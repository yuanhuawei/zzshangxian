<?php
defined('PHP168_PATH') or die();

$IS_ADMIN or exit('0');

if(REQUEST_METHOD == 'POST'){
	
	define('NO_ADMIN_LOG', true);
	
	$mid = isset($_POST['mid']) ? intval($_POST['mid']) : 0;
	$this_module->set_model($mid) or exit('false');
	
	$name = isset($_POST['name']) ? $this_controller->valid_name($_POST['name']) : '';
	
	$this_controller->check_field_name($name) or exit('false');
	
	exit('true');
}