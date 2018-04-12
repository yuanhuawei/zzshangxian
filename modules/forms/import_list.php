<?php
defined('PHP168_PATH') or die();

/**
* 导入CMS模型
**/

$this_controller->check_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	$mid = isset($_GET['mid'])? intval($_GET['mid']) : '';
	$this_module->set_model($mid) or message('no_such_forms_model');
	$this_controller->check_model_action('import_list',$mid) or message('no_model_privilege');
	include template($this_module, 'import_list');
}else if(REQUEST_METHOD == 'POST'){
	include $this_module->path .'call/import_list.call.php';
}