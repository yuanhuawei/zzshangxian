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

$MODEL = empty($MODEL) ? '' : $MODEL;


if($system != 'core' && !get_system($system)){
	message('no_such_system');
}

if($module && !get_module($system, $module)){
	message('no_such_module');
}

//数据源模块信息
$_POST['source_system'] = $this_system->name;
$_POST['source_module'] = $this_module->name;
//标签类型为模块数据
$_POST['type'] = 'module_data';

$controller = &$core->controller($LABEL);

$option = isset($_POST['option']) && is_array($_POST['option']) ? $_POST['option'] : array();

//标签通用部分,把验证好的数据覆盖原来的数据
$option = $controller->valid_module_data_option($option) + $option;
unset($option['order_by_desc']);
$option['var_fields'] = array();

//当前模型
$option['model'] = $MODEL;



//是否开启sphinx搜索功能
!empty($option['sphinx']) && $option['sphinx']['enabled'] = 1;


$option['fields'] = isset($option['fields']) && is_array($option['fields']) ? $option['fields'] : array();

//开始构造select
$select = select();
	
$select->from($this_module->table .' AS i', 'i.*');
$select->inner_join($this_module->data_table .' AS a', 'a.*', 'a.id = i.id');
if($option['status'] !=''){
	$select->in('i.status',$option['status']);
 }else{
	unset($option['status']);
 }
if($option['recommend'] >=0){
	$select->in('i.recommend',$option['recommend']); 
}	
//排序
$str = $comma = '';
foreach($option['order_by'] as $field => $desc){
	if(!isset($order_bys[$field])) continue;
	
	$str .= $comma . $field .($desc ? ' DESC' : ' ASC');
	$comma = ',';
}

if($str){
	$select->order($str);
	$option['order_by_string'] = $str;
}


//限制
$select->limit(0, $option['limit']);


$_POST['option'] = $option;		//选项