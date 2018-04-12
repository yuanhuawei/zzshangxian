<?php
defined('PHP168_PATH') or die();

/**
* 修改一个积分类型
**/

//如果要很详细的权限用$ACTION,如果合并权限用manage
//$this_controller->check_admin_action('manage') or message('no_privilege');
$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	
	$data = $this_module->view($id);
	
	$systems = &$core->systems;
	
	load_language($core, 'config');
	
	$core->get_cache('credit');
	
	include template($this_module, 'edit', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	
	$this_controller->update($id, $_POST);
	
	message('done');
}