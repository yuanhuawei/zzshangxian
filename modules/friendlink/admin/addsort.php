<?php
defined('PHP168_PATH') or die();

/**
* ��������������
**/

$this_controller->check_admin_action('sort') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	include template($this_module, 'sort_edit', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	if($this_controller->add_sort($_POST)){
		message('done');
	} else{
		message('fail');
	}
		
}