<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$this_module->get_cache();
	$this_module->get_group_cache();
	
	$system = isset($_GET['system']) ? $_GET['system'] : 'core';
		
	load_language($core, 'config');

	$system_list = &$core->systems;

	$list = $this_module->get_by_system($system);
	
	$role = &$this_module;

	include template($this_module, 'list', 'admin');

}elseif(REQUEST_METHOD == 'POST'){
//ÅÅÐò
	$display_order = isset($_POST['_display_order']) && is_array($_POST['_display_order']) ? array_map('intval', $_POST['_display_order']) : array();

	foreach((array)$display_order as $id => $order){
		$DB_master->update(
			$this_module->table,
			array(
				'display_order' => $order
			),
			"id = '$id'"
		);
	}
	$this_module->cache_role();
	message('done');

}