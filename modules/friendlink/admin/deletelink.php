<?php
defined('PHP168_PATH') or die();

/**
 * ɾ����������
 **/

$this_controller->check_admin_action('link') or exit('[]');

if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? filter_int($_POST['id']) : array();
	$id or exit('[]');

	if($this_module->delete_link($id)){
		exit(jsonencode($id));
	}
	exit('[]');
	
}else{
	message('error');
	exit;
}