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
	'feed'=>array(
		'dateline' =>'uchome_order_by_dateline',
		'hot' =>'uchome_order_by_hot',
	),
	'blog'=>array(
		'dateline' =>'uchome_order_by_dateline',
		'viewnum' =>'uchome_order_by_viewnum',
		'replynum' =>'uchome_order_by_replynum',
		'hot' =>'uchome_order_by_hot',
	),
	'album'=>array(
		'dateline' =>'uchome_order_by_dateline',
		'updatetime' =>'uchome_order_by_updatetime',
		'picnum' =>'uchome_order_by_picnum',
	),
	'pic'=>array(
		'dateline' =>'uchome_order_by_dateline',
		'size' =>'uchome_order_by_size',
		'hot' =>'uchome_order_by_hot',
	),
	'event'=>array(
		'dateline' =>'uchome_order_by_dateline',
		'updatetime' =>'uchome_order_by_starttime',
		'picnum' =>'uchome_order_by_membernum',
		'hot' =>'uchome_order_by_hot',
	),
	'thread'=>array(
		'dateline' =>'uchome_order_by_dateline',
		'viewnum' =>'uchome_order_by_viewnum',
		'replynum' =>'uchome_order_by_replynum',
	),
	'space'=>array(
		'dateline' =>'uchome_order_by_dateline',
		'updatetime' =>'uchome_order_by_updatetime',
		'viewnum' =>'uchome_order_by_viewnum',
		'experience' =>'uchome_order_by_experience',
		'credit' =>'uchome_order_by_credit',
		'friendnum' =>'uchome_order_by_friendnum',
	)
);

$action = isset($_GET['action']) ? $_GET['action'] : '';
$type = isset($_REQUEST['data_type']) ? $_REQUEST['data_type'] : '';


$types = array(
	'feed' => 'uchome_type_feed',
	'blog' => 'uchome_type_blog',
	'album' => 'uchome_type_album',
	'pic' => 'uchome_type_pic',
	'event' => 'uchome_type_event',
	'thread' => 'uchome_type_thread',
	'space' => 'uchome_type_space'
);
//in_array($type, $types) or message('access_denied');

if($type=='event'){
	$classes = $this_module->get_event_class();
}
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
