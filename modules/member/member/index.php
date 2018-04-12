<?php
defined('PHP168_PATH') or die();

require_once $this_module->path .'inc/menu.class.php';

$member_menu->get_cache();
//菜单JSON
$json = $CACHE->read('core/modules', 'member', 'menu_json');
//被禁止菜单的JSON
if($IS_FOUNDER){
	$denied = '{}';
}else{
	if($site = get_cookie('site')){
		$denied = $CACHE->read('core/modules', 'member', 'menu_json_role_'. $core->ROLE.'_'.$site);
	}
	if(empty($denied))
		$denied = $CACHE->read('core/modules', 'member', 'menu_json_role_'. $core->ROLE);
	!empty($denied) || $denied = '{}';
}

$this_module->set_model($ROLE_GROUP);
$data = $this_module->get_member_info($UID);

$message = $core->load_module('message');
$message->my_message();

include template($this_module, 'index');
