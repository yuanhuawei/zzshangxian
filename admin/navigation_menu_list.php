<?php
defined('PHP168_PATH') or die();
/**Í·²¿µ¼º½**/
$this_controller->check_admin_action('navigation_menu') or message('no_privilege');
require_once PHP168_PATH .'admin/inc/navigation_menu.class.php';
if(REQUEST_METHOD == 'GET'){	
	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	load_language($core, 'config');	
	$navigation_menu->cache(false);	
	$config = $core->get_config('core', '');
	include template($core, 'menu/navigation_menu_list', 'admin');	
}else if(REQUEST_METHOD == 'POST'){
$config = isset($_POST['config']) && is_array($_POST['config']) ? $_POST['config'] : array();
	
	$orig_admin_controller = $core->CONFIG['admin_controller'];
	$config['ShowMenu']=empty($config['ShowMenu'])? 0 :1;
	$config['CoreMenu']=empty($config['CoreMenu'])? 0 :1;
	$core->set_config($config);
	message('done');
}