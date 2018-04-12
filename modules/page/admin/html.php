<?php
defined('PHP168_PATH') or die();

/**
* ¶ÀÁ¢Ò³Éú³É¾²Ì¬
**/

$this_controller->check_admin_action('edit') or message('no_privilege');

if(REQUEST_METHOD == 'POST'){
	$ids = isset($_POST['ids']) ? filter_int($_POST['ids']) : '';
	
	if(!is_array($ids)) message('access_denied');
	
	$ids = implode(',', $ids);
	$query = $DB_master->query("SELECT * FROM {$this_module->table} WHERE id in($ids)");
	
	$this_module->html($query);
	
	message('done');
}