<?php
defined('PHP168_PATH') or die();

/**
* ���õ�ǰϵͳ������ģ��Ĺ���ԱȨ�޿���
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){

	
		include template($this_system, 'html_item', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	
	
	message('done');
}