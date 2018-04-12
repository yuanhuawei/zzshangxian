<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or die();

load_language($this_system, 'admin');

if(REQUEST_METHOD == 'GET'){
	
	$this_module->cache(false, false);
	$json = $this_module->get_json();
	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	if(!empty($id) && !$this_controller->check_exists(array('id'=>$id))){
		$id = 0;
	}

	include template($this_module, 'batch_add', 'admin');

}
elseif(REQUEST_METHOD == 'POST'){

	$ids = '';

	$ids = $this_controller->batch_add($_POST) or message('ask_error', HTTP_REFERER, 3);
	
	message('ask_category_add_success', $this_router."-batch_edit?ids=$ids", 1);

}