<?php
defined('PHP168_PATH') or die();
/**
* ¸´ÖÆ±êÇ©
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	$id or message('no_such_item');
	
	$data = $this_module->view($id);
	
	$name = $data['name'];
	
	$system = $module = '';
	include template($this_module, 'copy', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$id or message('no_such_item');
	
	$name = isset($_POST['name']) ? $_POST['name'] : '';
	$name or message('label_name_invalid');
	
	$label = $this_module->view($id);
	$label or message('no_such_item');
	
	$label['name'] = $name;
	$this_controller->add($label) or message('fail');
	
	message('done');
}
