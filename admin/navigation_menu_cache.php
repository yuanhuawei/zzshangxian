<?php
defined('PHP168_PATH') or die();

/**
* 更新导航菜单缓存
**/

$this_controller->check_admin_action('navigation_menu') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){	
	load_language($core, 'config');
	include template($core, 'menu/navigation_menu_cache', 'admin');	
}else if(REQUEST_METHOD == 'POST'){	
	require_once PHP168_PATH .'admin/inc/navigation_menu.class.php';	
	//排序
	$display_order = isset($_POST['_display_order']) && is_array($_POST['_display_order']) ? array_map('intval', $_POST['_display_order']) : array();	
	//显示
	$display = isset($_POST['display_json']) ? jsondecode((MAGIC_QUOTES ? stripcslashes($_POST['display_json']) : $_POST['display_json'])) : array();	
	foreach((array)$display_order as $id => $order){
		$DB_master->update(
			$navigation_menu->table,
			array(
				'display_order' => $order
			),
			"id = '$id'"
		);
	}	
	foreach((array)$display as $id => $v){
		$DB_master->update(
			$navigation_menu->table,
			array(
				'display' => (int)$v
			),
			"id = '$id'"
		);
	}

	$navigation_menu->cache();

	message('done',$this_router.'-navigation_menu_list');
}
