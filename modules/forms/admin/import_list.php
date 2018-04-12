<?php
defined('PHP168_PATH') or die();

/**
* 导入CMS模型
**/

//$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	$mid = isset($_GET['mid'])? intval($_GET['mid']) : '';
	$this_controller->check_model_action('import_list',$mid) or message('no_privilege');
	$this_module->set_model($mid) or message('no_such_forms_model');
	include template($this_module, 'import_list', 'admin');
}else if(REQUEST_METHOD == 'POST'){
	include $this_module->path .'call/import_list.call.php';
}