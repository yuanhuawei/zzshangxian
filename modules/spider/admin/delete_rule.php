<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action('rule') or message('no_privilege');

if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? filter_int($_POST['id']) : array();
	$id or exit('[]');
	
	$this_module->delete_rule(array(
		'where' => 'id IN ('. implode(',', $id) .')'
	));
	
	exit(p8_json($id));
}