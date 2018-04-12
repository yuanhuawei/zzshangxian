<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

load_language($this_system, 'admin');

if(REQUEST_METHOD == 'GET'){

	P8_AJAX_REQUEST or message('ask_error');

	$ids_arr = array();

	$ids = !empty($_GET['ids']) && $this_controller->valid_array($_GET['ids']) ? $_GET['ids'] : array();
	
	foreach($ids as $id){
		if($this_controller->check_exists(array('id'=>$id))){
			$ids_arr[] = $id;
		}
	}	

	if(empty($ids_arr)){
		message('ask_error');
	}
	
	include template($this_module, 'set_display_order', 'admin');

}
elseif(REQUEST_METHOD == 'POST'){

	P8_AJAX_REQUEST or die();

	$json = $this_controller->set_display_order($_POST) or die();

	echo jsonencode($json);
	exit;

}