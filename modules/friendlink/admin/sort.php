<?php
defined('PHP168_PATH') or die();

/**
 * �������ӷ����б� 
 */

$this_controller->check_admin_action('sort') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	
	$select = select();

	$select->from($this_module->table_sort, '*');
	$sorts = $core->list_item($select);
	
	include template($this_module, 'sort', 'admin');
}else{
	message('error');
}