<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action('menu') or message('no_privilege');

require_once PHP168_PATH .'admin/inc/menu.class.php';

if(REQUEST_METHOD == 'GET'){
	
	load_language($core, 'config');
	
	$systems = &$core->systems;
	$admin_menu->get_cache();
	
	include template($core, 'menu_edit', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	isset($_POST['name']) && strlen($_POST['name']) or message('menu_name_can_not_be_empty');
	$name = html_entities($_POST['name']);
	
	//有URL的情况数据可以任意,以URL为准
	$url = isset($_POST['url']) ? $_POST['url'] : '';
	$target = isset($_POST['target']) ? $_POST['target'] : '';
	
	$parent = isset($_POST['parent']) ? intval($_POST['parent']) : 0;
	
	$system = isset($_POST['system']) ? $_POST['system'] : '';
	if($system != 'core' && !get_system($system) && !$url)
		message('no_such_system');
	
	$module = isset($_POST['module']) ? $_POST['module'] : '';
	if($module && !get_module($system, $module) && !$url)
		message('no_such_module');
	
	$action = isset($_POST['action']) ? $_POST['action'] : '';
	
	$display = isset($_POST['display']) ? intval($_POST['display']) : 0;
	$front = isset($_POST['front']) ? intval($_POST['front']) : 0;
	$display_order = isset($_POST['display_order']) ? intval($_POST['display_order']) : 0;
	
	$admin_menu->add(
		array(
			'name' => $name,
			'parent' => $parent,
			'system' => $system,
			'module' => $module,
			'action' => $action,
			'url' => $url,
			'target' => $target,
			'display' => $display,
			'front' => $front,
			'display_order' => $display_order
		)
	) or message('fail');
	
	//生成缓存
	unset($admin_menu);
	$admin_menu = new P8_Admin_Menu();
	$admin_menu->cache();
	
	message('done');
	
}

