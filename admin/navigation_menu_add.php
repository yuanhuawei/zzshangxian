<?php
defined('PHP168_PATH') or die();
/**
* 添加导航菜单
**/
$this_controller->check_admin_action('navigation_menu') or message('no_privilege');
require_once PHP168_PATH .'admin/inc/navigation_menu.class.php';
if(REQUEST_METHOD == 'GET'){	
	load_language($core, 'config');	
	$systems = &$core->systems;
	$navigation_menu->get_cache();	
	include template($core, 'menu/navigation_menu_edit', 'admin');	
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
	$color = isset($_POST['color']) ? $_POST['color'] : '';	
	$display = isset($_POST['display']) ? intval($_POST['display']) : 0;
	$display_order = isset($_POST['display_order']) ? intval($_POST['display_order']) : 0;	
	$navigation_menu->add(
		array(
			'name' => $name,
			'parent' => $parent,
			'system' => $system,
			'module' => $module,
			'color' => $color,
			'url' => $url,
			'target' => $target,
			'display' => $display,
			'display_order' => $display_order
		)
	) or message('fail');
	
	//生成缓存
	unset($navigation_menu);
	$navigation_menu = new P8_Navigation_Menu();
	$navigation_menu->cache();
	
	message('done');
}

