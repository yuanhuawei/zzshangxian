<?php
defined('PHP168_PATH') or die();

/**
* ɾ��ģ��
**/

$this_controller->check_admin_action($ACTION) or exit('0');

if(REQUEST_METHOD == 'POST'){
	
	@set_time_limit(0);
	
	$name = isset($_POST['name']) ? $this_controller->valid_name($_POST['name']) : '';
	$name or exit('0');
	//����ģ�Ͳ���ɾ��
	if($name == 'article') exit('0');
	
	$this_controller->delete($name) or exit('0');
	
	exit('1');
}