<?php
defined('PHP168_PATH') or die();

$IS_ADMIN or exit('0');

if(REQUEST_METHOD == 'POST'){
	
	define('NO_ADMIN_LOG', true);
	
	$model = isset($_POST['model']) ? $this_controller->valid_name($_POST['model']) : '';
	$model or exit('false');
	
	$check = $this_module->get_model($model);
	$check or exit('false');
	
	$name = isset($_POST['name']) ? $this_controller->valid_name($_POST['name']) : '';
	
	$this_controller->check_field_name($model, $name) or exit('false');
	
	exit('true');
}