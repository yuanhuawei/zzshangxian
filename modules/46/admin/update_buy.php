<?php
defined('PHP168_PATH') or die();

/**
 * 广告管理
 */

$this_controller->check_admin_action('buy') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	$id or message('no_such_item');
	
	$data = $this_module->get_buy($id);
	$data or message('no_such_item');
	
	$ad = $this_module->get($data['aid']);
	$ad or message('no_such_item');
	
	include template($this_module, 'buy', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$id or message('no_such_item');
	
	$this_controller->update_buy($_POST);
	
	message('done');
}