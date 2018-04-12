<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

$data['type'] = 'module_data';

$LABEL = &$core->load_module('label');

load_language($core, 'config');
load_language($LABEL, 'global');
load_language($this_system, 'admin');
load_language($this_module, 'label');

$category = &$this_system->load_module('category');
$json = $category->get_json();	
//ÔÊÐíµÄÅÅÐò×Ö¶Î	×Ö¶Î => ÓïÑÔ°ü¼üÖµ
$order_bys = array(
	'i.id' => 'ask_member_order_id',
	'i.item_count' => 'ask_member_order_items',
	'i.solve_item_count' => 'ask_member_order_solved_items',
	'i.reply_count' => 'ask_member_order_replies',
	'i.last_reply_time' => 'ask_member_order_last'
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