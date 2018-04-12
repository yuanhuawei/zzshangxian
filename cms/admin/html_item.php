<?php
defined('PHP168_PATH') or die();

/**
* 设置当前系统及所属模块的管理员权限开关
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){

	
		include template($this_system, 'html_item', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	
	
	message('done');
}