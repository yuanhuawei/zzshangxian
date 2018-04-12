<?php
defined('PHP168_PATH') or die();

/**
 * ทรฬธนÜภํ
 */

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	
	$select = select();
	$select->from("{$this_module->table_subject} AS s", 's.*');
	$subjects = $core->list_item($select);
	
	include template($this_module, 'list_subject', 'admin');
}else{
	
	message('error');
}

?>