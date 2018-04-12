<?php
defined('PHP168_PATH') or die();

/**
* 更新会员中心菜单缓存
**/

$this_controller->check_admin_action('member_menu') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	load_language($core, 'config');
	include template($core, 'member_menu_cache', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	require_once PHP168_PATH .'/modules/member/inc/menu.class.php';
	
	//排序
	$display_order = isset($_POST['_display_order']) && is_array($_POST['_display_order']) ? array_map('intval', $_POST['_display_order']) : array();
	
	//显示
	$display = isset($_POST['display_json']) ? jsondecode(p8_stripslashes2($_POST['display_json'])) : array();
	
	foreach($display_order as $id => $order){
		$DB_master->update(
			$member_menu->table,
			array(
				'display_order' => $order
			),
			"id = '$id'"
		);
	}
	
	foreach($display as $id => $v){
		$DB_master->update(
			$member_menu->table,
			array(
				'display' => (int)$v
			),
			"id = '$id'"
		);
	}

	$member_menu->cache();

	message('done');
}
