<?php
defined('PHP168_PATH') or die();

/**
 * ������
 */

$this_controller->check_admin_action('ad') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	include template($this_module, 'edit', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$this_controller->add($_POST) or message('fail');
	
	message('done');
}