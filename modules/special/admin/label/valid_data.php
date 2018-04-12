<?php
defined('PHP168_PATH') or die();

/**
* 数据过滤,将option中的选项存到数据库,同时也作SQL解析用
**/

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


//是否开启sphinx搜索功能
!empty($option['sphinx']) && $option['sphinx']['enabled'] = 1;

//分类
$option['category'] = empty($option['category']) ? array() : $option['category'];

//开始构造select
$select = select();
$select->from($this_module->table .' AS i', 'i.*');


//非指定ID
if(empty($option['ids'])){
	
	if($option['category']){
		if($controller->is_var_field($option['category'])){
			//变量字段
			
			$select->in('i.cid', $option['category']);
			$option['var_fields']['i.cid'] = array('operator' => 'in', 'var' => $option['category']);
			
			$option['unset_options'][] = 'category';
			
		}else{
			$option['category'] = preg_replace("/[^0-9,]/", '', $option['category']);
			//多余的,
			$option['category'] = filter_int(explode(',', $option['category']));
			$select->in('i.cid', $option['category']);
			
		}
		
	}
	
}else{
	
	//指定了ID其余的条件会被忽略
	
	$option['ids'] = filter_int(explode(',', $option['ids']));
	$select->in('i.id', $option['ids']);
}


//排序
$str = $comma = '';
foreach($option['order_by'] as $field => $desc){
	$str .= $comma . $field .($desc ? ' DESC' : ' ASC');
	$comma = ',';
}

if($str){
	$select->order($str);
	$option['order_by_string'] = $str;
}

if(!empty($option['attribute'])){
	//有属性以属性的时间戳为排序条件
	$option['order_by_string'] = 'a.timestamp DESC';
	$select->order('a.timestamp DESC');
}

//限制
$select->limit(0, $option['limit']);