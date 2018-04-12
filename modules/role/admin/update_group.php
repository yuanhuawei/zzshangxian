<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	
	$data = $this_module->view_group($id);
	
	$this_module->get_cache();
	
	$roles = $this_module->get_by_group($id, 'core');
	
	include template($this_module, 'edit_group', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	
	$this_controller->update_group($id, $_POST);
	
	$this_module->cache_group();
	
	message('done');
}