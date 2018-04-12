<?php
defined('PHP168_PATH') or die();
$is_admin=$this_controller->check_action('admin_replay');
if(REQUEST_METHOD == 'GET'){
	$id = intval($_GET['id']) or message('error');
	$data = $this_module->data($id);
	if(!$data)message('error');
	$this_module->delete($id);
	message('done',$this_router.'-list');
}