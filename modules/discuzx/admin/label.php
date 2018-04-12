<?php
defined('PHP168_PATH') or die();

/**
* 标签操作入口
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

$data['type'] = 'module_data';

$LABEL = &$core->load_module('label');
load_language($LABEL, 'global');
load_language($this_module, 'label');
load_language($core, 'config');

//允许的排序字段	字段 => 语言包键值
$order_bys = array(
	't.lastpost'		=> 'discuzx_order_by_default',
	't.displayorder'	=> 'discuzx_order_by_displayorder',
	't.dateline'		=> 'discuzx_order_by_date',
	't.tid'				=> 'discuzx_order_by_id',
	't.views'			=> 'discuzx_order_by_views',
	't.replies'			=> 'discuzx_order_by_replies',
);

$action = isset($_GET['action']) ? $_GET['action'] : '';
$type = isset($_REQUEST['data_type']) ? $_REQUEST['data_type'] : '';

$types = array(
	'thread' => 'discuzx_type_thread',
	//'feed' => 'discuzx_type_feed',
	'member' => 'discuzx_type_member',
);
//in_array($type, $types) or message('access_denied');

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