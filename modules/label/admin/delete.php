<?php
defined('PHP168_PATH') or die();

/**
* ɾ����ǩ
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? filter_int($_POST['id']) : array();
	$id or exit('[]');
	
	$this_module->delete(array(
		'where' => $this_module->table .'.id IN ('. implode(',', $id) .')'
	)) or exit('[]');
	
	exit(p8_json($id));
}