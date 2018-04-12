<?php
defined('PHP168_PATH') or die();

/**
* 标签操作入口
* @language [cms/item/global.php, core/label/global.php, core/config.php]
**/

$data['type'] = 'module_data';

if(isset($_REQUEST['model'])){
	$this_system->init_model();
}

$models = $this_system->get_models();



$LABEL = &$core->load_module('label');
load_language($LABEL, 'global');
load_language($this_module, 'global');
load_language($core, 'config');

//允许的排序字段	字段 => 语言包键值
$order_bys = array(
	'i.id'			=> 'cms_item_order_id',
	'i.timestamp'	=> 'cms_item_order_addtime',
	'i.views'		=> 'cms_item_order_views',
	'i.comments'	=> 'cms_item_order_comments',
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