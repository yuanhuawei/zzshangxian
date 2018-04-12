<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or exit('0');

if(REQUEST_METHOD == 'POST'){
	
	define('NO_ADMIN_LOG', true);
	
	$gid = isset($_POST['gid']) ? intval($_POST['gid']) : '';
	$gid or exit('false');
	
	$name = isset($_POST['name']) ? $_POST['name'] : '';
	
	$this_controller->check_group_field_name($gid, $name) or exit('false');
	
	exit('true');
}