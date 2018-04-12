<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action('member_menu') or message('no_privilege');

require_once PHP168_PATH .'/modules/member/inc/menu.class.php';

if(REQUEST_METHOD == 'GET'){
	
	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	
	load_language($core, 'config');
	
	//$admin_menu->get_cache();
	$member_menu->cache(false);
	
	$path = array();
 
	foreach($member_menu->menus as $v){
		$parents = $member_menu->get_parents($v['id']);
		foreach($parents as $vv){
			$path[$v['id']][] = $vv['id'];
		}
		$path[$v['id']][] = $v['id'];
	}

	$json = array(
		'json' => p8_json($member_menu->top_menus),
		'path' => p8_json($path)
	);
	
	include template($core, 'member_menu_list', 'admin');
	
}