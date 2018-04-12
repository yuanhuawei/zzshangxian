<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or die();

if(!P8_AJAX_REQUEST || REQUEST_METHOD == 'GET') die();

$category = array();

$this_module->cache(false,false);

if(!empty($_POST['id']) && $this_controller->check_exists(array('id'=>intval($_POST['id'])))){
	$categories = $this_module->categories[$_POST['id']];
}else{
	$categories = $this_module->top_categories;
}

echo jsonencode($categories);
exit;