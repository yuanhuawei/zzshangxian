<?php
defined('PHP168_PATH') or die();

/**
* Ìí¼Ó¶ÀÁ¢Ò³
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	
	$rsdb = $DB_master->fetch_one("SELECT * FROM {$this_module->table} WHERE id = '$id'");
	$rsdb or message('no_such_item');
	
	$rsdb['content'] = attachment_url($rsdb['content']);
	$rsdb['template'] = $this_controller->get_templatestyle();
	
	include template($this_module, 'edit', 'admin');

}else if(REQUEST_METHOD == 'POST'){
	
	$_POST = p8_stripslashes2($_POST);
	
	$this_controller->edit($_POST);
	
	message('done');
}