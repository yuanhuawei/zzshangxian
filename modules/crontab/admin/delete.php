<?php
defined('PHP168_PATH') or die();

/**
* ɾ���ƻ�����
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$id or exit('0');
	
	$this_module->delete($id) or exit('0');

	exit('1');
}