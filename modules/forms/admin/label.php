<?php
defined('PHP168_PATH') or die();

/**
* 标签操作入口
* @language [cms/item/global.php, core/label/global.php, core/config.php]
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

$data['type'] = 'module_data';

$models = $omodels = $this_module->core->CACHE->read('core/modules', 'forms', 'models');
if(!empty($_REQUEST['mid']) || !empty($_REQUEST['option']['mid'])){
	$mid = !empty($_REQUEST['mid'])? intval($_REQUEST['mid']) : intval($_REQUEST['option']['mid']);
	$this_module->set_model($mid);
	
	$this_model or message('no_such_cms_model');
	$MODEL = $this_module->MODEL;
	
}
$LABEL = &$core->load_module('label');
load_language($LABEL, 'global');
load_language($core, 'config');

//允许的排序字段	字段 => 语言包键值
$order_bys = array(
	'i.list_order'	=> $P8LANG['forms_item_order_default'],
	'i.display_order'	=> $P8LANG['forms_item_display_order'],
	'i.id'			=> $P8LANG['forms_item_order_id'],
	'i.timestamp'	=> $P8LANG['forms_item_order_addtime'],
	'i.views'		=> $P8LANG['forms_item_order_views'],
	'i.reply_time'	=> $P8LANG['forms_item_order_reply_time'],
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
