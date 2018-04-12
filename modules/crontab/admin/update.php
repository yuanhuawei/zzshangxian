<?php
defined('PHP168_PATH') or die();

/**
* 修改计划任务
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	$id or message('no_such_item');
	
	$select = select();
	$select->from($this_module->table, '*');
	$select->in('id', $id);
	$data = $core->select($select, array('single' => true));
	
	$data or message('no_such_item');
	
	include template($this_module, 'edit', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){

	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	
	$this_controller->update($id, $_POST);
	
	message('done', $this_router .'-list');
}