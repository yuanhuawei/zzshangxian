<?php
defined('PHP168_PATH') or die();

/**
 * 广告管理
 */

$this_controller->check_admin_action('ad') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$aid = isset($_GET['aid']) ? intval($_GET['aid']) : 0;
	$aid or message('no_such_item');
	
	$data['postfix'] = isset($_GET['postfix']) ? preg_replace('/[^0-9a-zA-Z_\-]/', '', $_GET['postfix']) : '';
	
	$ad = $this_module->get($aid);
	$ad or message('no_such_item');
	
	include template($this_module, 'buy', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$this_controller->add_buy($_POST);
	
	message('done');
}