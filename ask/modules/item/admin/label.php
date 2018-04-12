<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

$data['type'] = 'module_data';

$LABEL = &$core->load_module('label');

$category = &$this_system->load_module('category');
$category->get_cache(true);
$json = $category->get_json();	

load_language($LABEL, 'global');
load_language($core, 'config');
load_language($this_system, 'admin');
load_language($this_module, 'label');

//ÔÊÐíµÄÅÅÐò×Ö¶Î	×Ö¶Î => ÓïÑÔ°ü¼üÖµ
$order_bys = array(
	'i.id' => 'ask_item_order_id',
	'i.views' => 'ask_item_order_views',
	'i.replies' => 'ask_item_order_replies',
	'i.addtime' => 'ask_item_order_addtime',
	'i.lastpost' => 'ask_item_order_lastpost',
	'i.dateline' => 'ask_item_order_dateline',
	'i.solvetime' => 'ask_item_order_solvetime',
	'i.credits' => 'ask_item_order_credits'
);
$action = isset($_GET['action']) ? $_GET['action'] : '';
switch($action){
	case 'update':
		
		require $this_module->path .'admin/label/update.php';
	break;
	
	case 'explain':
		require $this_module->path .'admin/label/explain.php';
	break;
	case 'preview':
		require $this_module->path .'admin/label/preview.php';
	break;
	default:
		require $this_module->path .'admin/label/add.php';
	break;
}