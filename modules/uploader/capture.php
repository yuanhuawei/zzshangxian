<?php
defined('PHP168_PATH') or die();

$this_controller->check_action($ACTION) or message('no_privilege');

/**
* 从网络上捕抓文件
**/

$system = isset($_GET['system']) ? $_GET['system'] : 'core';
$module = isset($_GET['module']) ? $_GET['module'] : '';

if(!$module && !get_module($system, $module)){
	message('no_such_item');
}

if(REQUEST_METHOD == 'POST'){
	$file = isset($_POST['upload_files']) && is_array($_POST['upload_files']) ? $_POST['upload_files'] : array();
	
	$json = jsonencode($this_controller->capture($system, $module, $file));
	setcookie('p8_upload_json', $json, 0, '/');
	echo $json;
	exit;
}