<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action('menu') or message('no_privilege');

require_once PHP168_PATH .'admin/inc/menu.class.php';

if(REQUEST_METHOD == 'GET'){
	
	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	
	load_language($core, 'config');
	
	//$admin_menu->get_cache();
	$admin_menu->cache(false);
	
	$path = array();
 
	foreach($admin_menu->menus as $v){
		$parents = $admin_menu->get_parents($v['id']);
		foreach($parents as $vv){
			$path[$v['id']][] = $vv['id'];
		}
		$path[$v['id']][] = $v['id'];
	}

	$json = array(
		'json' => p8_json($admin_menu->top_menus),
		'path' => p8_json($path)
	);
	
	include template($core, 'menu_list', 'admin');
	
}