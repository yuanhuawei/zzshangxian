<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or exit('0');

if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	
	if($this_module->delete_group_field($id)){
		$this_module->cache_group();
		exit('1');
	}
	
	exit('0');
}