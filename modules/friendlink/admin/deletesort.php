<?php
defined('PHP168_PATH') or die();

/**
 * 删除友情链接分类
 **/

$this_controller->check_admin_action('sort') or exit('[]');

if(REQUEST_METHOD == 'POST'){
	
	$fid = isset($_POST['fid']) ? filter_int($_POST['fid']) : array();
	$fid or exit('[]');

	if($this_module->delete_sort($fid)){
		exit(jsonencode($fid));
	}
	exit('[]');
	
}else{
	message('error');
	exit;
}