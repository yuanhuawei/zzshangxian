<?php
defined('PHP168_PATH') or die();

/**
* ɾ������Ϣ,ֻ�ṩAJAX����
**/

$this_controller->check_admin_action($ACTION) or exit('[]');

if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? filter_int($_POST['id']) : array();
	$id or exit('[]');
	
	$this_module->delete(array(
		'where' => 'id IN ('. implode(',', $id) .')'
	)) or exit('[]');
	
	exit(jsonencode($id));
}