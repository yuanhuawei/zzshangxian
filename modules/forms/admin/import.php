<?php
defined('PHP168_PATH') or die();

/**
* 导入CMS模型
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
		
	include template($this_module, 'import', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	$step = $_POST['step'];
	
	if($step == 1){
		$name = isset($_POST['name']) ? basename($_POST['name']) : '';
		is_dir($this_module->path .'#export/'. $name) or message('no_such_forms_model');
		$data = include $this_module->path .'#export/'. $name.'/#data.php';
		include template($this_module, 'import', 'admin');
	}else if($step == 2){
		@set_time_limit(0);
		
		$post['name'] = isset($_POST['name']) ? basename($_POST['name']) : '';
		$post['alias'] = isset($_POST['alias']) ? html_entities($_POST['alias']) : '';
		$post['template'] = isset($_POST['template']) ? $_POST['template'] : '';
		if(!$post['name'] || !$post['alias'])message('error');
		$oname = isset($_POST['oname']) ? basename($_POST['oname']) : '';
		is_dir($this_module->path .'#export/'. $oname) or message('no_such_forms_model');
		$this_module->import($post, $oname) or message('fail');
		
		message('done');
	}
}