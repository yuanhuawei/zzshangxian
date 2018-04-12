<?php
defined('PHP168_PATH') or die();

/**
* 重命名附件,只提供AJAX调用
**/

$this_controller->check_action('upload') or exit('0');

if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$id or exit('0');
	
	$system = isset($_POST['system']) ? $_POST['system'] : '';
	
	if($system != 'core' && !get_system($system)) exit('0');
	
	$name = isset($_POST['name']) ? html_entities(from_utf8($_POST['name'])) : '';
	
	$this_module->set($system);
	
	$DB_master->update(
		$this_module->table,
		array(
			'filename' => $name
		),
		"id = '$id' AND uid = '$UID'"
	);
	
	exit('1');
}