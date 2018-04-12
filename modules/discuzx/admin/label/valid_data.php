<?php
defined('PHP168_PATH') or die();

/**
* 数据过滤,将option中的选项存到数据库,同时也作SQL解析用
**/

if($action == 'explain'){
	$_POST = p8_stripslashes2(from_utf8($_POST));
}

//作用域
$system = isset($_POST['system']) ? $_POST['system'] : '';
$module = isset($_POST['module']) ? $_POST['module'] : '';


if($system != 'core' && !get_system($system)){
	message('no_such_system');
}

if($module && !get_module($system, $module)){
	message('no_such_module');
}

//数据源模块信息
$_POST['source_system'] = $SYSTEM;
$_POST['source_module'] = $MODULE;
//标签类型为模块数据
$_POST['type'] = 'module_data';

$controller = &$core->controller($LABEL);

$option = isset($_POST['option']) && is_array($_POST['option']) ? $_POST['option'] : array();

//标签通用部分,把验证好的数据覆盖原来的数据
$option = $controller->valid_module_data_option($option) + $option;
unset($option['order_by_desc']);
$option['var_fields'] = array();

$option['type'] = $type;

//转发
require $this_module->path .'admin/label/valid_data_'. $type .'.php';