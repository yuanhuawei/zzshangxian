<?php
defined('PHP168_PATH') or die();

/**
* ɾ����������
**/

//���Ҫ����ϸ��Ȩ����$ACTION,����ϲ�Ȩ����manage
//$this_controller->check_admin_action('manage') or message('no_privilege');
$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	
	$this_module->delete($id) or exit('0');
	
	exit('1');
}
exit('0');