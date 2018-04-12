<?php
defined('PHP168_PATH') or die();

/**
* 删除积分类型
**/

//如果要很详细的权限用$ACTION,如果合并权限用manage
//$this_controller->check_admin_action('manage') or message('no_privilege');
$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	
	$this_module->delete($id) or exit('0');
	
	exit('1');
}
exit('0');