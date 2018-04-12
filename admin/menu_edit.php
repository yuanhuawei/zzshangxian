<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action('menu') or message('no_privilege');

require_once PHP168_PATH .'admin/inc/menu.class.php';

if(REQUEST_METHOD == 'GET'){
	
	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	
	$id or message('no_such_item');
	
	$data = $admin_menu->view($id);
	
	$data or message('no_such_item');
	
	load_language($core, 'config');
	
	$admin_menu->get_cache();
	
	$parents = $admin_menu->get_parents($data['id']);
	$top = array_shift($parents);
	
	$parent_js = '[';
	$comma = '';
	foreach($parents as $v){
		$parent_js .= $comma . $v['id'];
		$comma = ',';
	}
	$parent_js .= '];';
	
	$systems = &$core->systems;
	
	include template($core, 'menu_edit', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	
	$id or message('no_such_item');
	
	$admin_menu->get_cache();
	$admin_menu->update($id, $_POST) or message('fail');
	
	unset($admin_menu);
	$admin_menu = new P8_Admin_Menu();
	$admin_menu->cache();
	
	message('done');
}

