<?php
defined('PHP168_PATH') or die();

/**
* ±à¼­µ¼º½²Ëµ¥
**/
$this_controller->check_admin_action('navigation_menu') or message('no_privilege');

require_once PHP168_PATH .'admin/inc/navigation_menu.class.php';

if(REQUEST_METHOD == 'GET'){
	
	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	
	$id or message('no_such_item');
	
	$data = $navigation_menu->view($id);
	
	$data or message('no_such_item');
	
	load_language($core, 'config');
	
	$navigation_menu->get_cache();
	
	$parents = $navigation_menu->get_parents($data['id']);
	$top = array_shift($parents);
	
	$parent_js = '[';
	$comma = '';
	foreach($parents as $v){
		$parent_js .= $comma . $v['id'];
		$comma = ',';
	}
	$parent_js .= '];';
	
	$systems = &$core->systems;
	
	include template($core, 'menu/navigation_menu_edit', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	
	$id or message('no_such_item');
	
	$navigation_menu->get_cache();
	$navigation_menu->update($id, $_POST) or message('fail');
	
	unset($navigation_menu);
	$navigation_menu = new P8_Navigation_Menu();
	$navigation_menu->cache();
	
	message('done');
}

