<?php
defined('PHP168_PATH') or die();

/**
* 清空投票结果
**/

$this_controller->check_admin_action($ACTION) or exit('0');

if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$id or exit('0');
	
	$DB_master->update($this_module->table, array('votes' => 0), "id = '$id'");
	$DB_master->update($this_module->option_table, array('votes' => 0), "vid = '$id'");
	$DB_master->delete($this_module->voter_table, "vid = '$id'");
	
	$this_module->cache($id);
	
	exit('1');
	
}