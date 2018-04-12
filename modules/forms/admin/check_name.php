<?php
defined('PHP168_PATH') or die();

$IS_ADMIN or exit('0');

if(REQUEST_METHOD == 'POST'){
	
	define('NO_ADMIN_LOG', true);
	
	$name = isset($_POST['name']) ? $this_controller->valid_name($_POST['name']) : '';
	$name or exit('false');
	
	//如果数据库里面有数据,或者模型文件夹里面有未删除的模型
	$this_controller->check_model_name($name) or exit('false');

	exit('true');
}