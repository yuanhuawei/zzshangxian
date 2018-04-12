<?php
defined('PHP168_PATH') or die();
$is_admin=$this_controller->check_action('admin_replay');
if(REQUEST_METHOD == 'GET'){
	$id = intval($_GET['id']) or message('error');
	$data = $this_module->data($id);
	$category = $this_module->CONFIG['cs_category'];
	$attachment_hash = unique_id(16);
include template($this_module, "post");
}else if(REQUEST_METHOD=='POST'){
	$this_controller->updateask($_POST);
	message('done',$this_router.'-list');
}