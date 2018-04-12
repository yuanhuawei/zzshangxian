<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

P8_AJAX_REQUEST or message('ask_error');

load_language($this_system, 'admin');

if(REQUEST_METHOD == 'GET'){

	//载入分类模块
	$category = $this_system->load_module('category');
	$category -> get_cache(true);

	$allids = $comma = '';
	$ids = !empty($_GET['ids']) && is_array($_GET['ids']) ? $_GET['ids'] : array();

	if(empty($ids)) message('ask_error');

	if(empty($category->top_categories)) message('ask_category_empty');

	//检查用户是否存在
	foreach($ids as $id){
		if($this_controller->check_exists(array('id'=>$id))){
			$allids .= $comma . $id;
			$comma = ',';
		}
	}

	if(empty($allids)) message('ask_error');
	
	include template($this_module, 'set_expertor', 'admin');

}

elseif(REQUEST_METHOD == 'POST'){

	$json = $this_controller->set_expertor($_POST) or die();
	echo jsonencode($json);
	
}
exit;