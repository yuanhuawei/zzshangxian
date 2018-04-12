<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	
	$data = $this_module->view($id);
	
	$systems = &$core->systems;
	
	$this_module->get_group_cache();
	
	include template($this_module, 'edit', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	
	$this_controller->update($id, $_POST) or message('fail');
	
	$this_module->cache();
	
	message('done');
}