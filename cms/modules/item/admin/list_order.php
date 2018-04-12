<?php
defined('PHP168_PATH') or die();

/**
* 置顶/下沉 内容,只提供AJAX
**/

$this_controller->check_admin_action($ACTION) or exit('[]');

if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? filter_int($_POST['id']) : array();
	$id or exit('[]');
	
	$time = isset($_POST['time']) && ($timestamp = strtotime($_POST['time'])) ? $timestamp : 0;
	
	$this_module->list_order($id, $timestamp) or exit('[]');
	
	exit(p8_json($id));
}