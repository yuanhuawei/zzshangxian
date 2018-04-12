<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action('menu') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	load_language($core, 'config');
	include template($core, 'menu_cache', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	require_once PHP168_PATH .'admin/inc/menu.class.php';
	
	//ÅÅÐò
	$display_order = isset($_POST['_display_order']) && is_array($_POST['_display_order']) ? array_map('intval', $_POST['_display_order']) : array();
	
	//ÏÔÊ¾
	$display = isset($_POST['display_json']) ? jsondecode(p8_stripslashes2($_POST['display_json'])):array();
	
	foreach((array)$display_order as $id => $order){
		$DB_master->update(
			$admin_menu->table,
			array(
				'display_order' => $order
			),
			"id = '$id'"
		);
	}
	
	foreach((array)$display as $id => $v){
		$DB_master->update(
			$admin_menu->table,
			array(
				'display' => (int)$v
			),
			"id = '$id'"
		);
	}

	$admin_menu->cache();

	message('done',$this_router.'-menu_list');
}
