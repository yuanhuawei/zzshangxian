<?php
defined('PHP168_PATH') or die();

/**
* ɾ��CMS����,ֻ�ṩAJAX����
**/

$this_controller->check_admin_action($ACTION) or exit('[]');


if(REQUEST_METHOD == 'POST'){
	
	@set_time_limit(0);
	
	$id = isset($_POST['id']) ? filter_int($_POST['id']) : array();
	$id or exit('[]');
	
	$ret = $this_module->delete(array(
		'where' => 'id IN ('. implode(',', $id) .')',
		'delete_hook' => true
	)) or exit('[]');
	
	$this_module->cache();
	
	exit(jsonencode($ret));
}