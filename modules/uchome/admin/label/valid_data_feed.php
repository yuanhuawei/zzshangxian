<?php
defined('PHP168_PATH') or die();

/**
* 数据过滤,将option中的选项存到数据库,同时也作SQL解析用
**/

//是否开启sphinx搜索功能
!empty($option['sphinx']) && $option['sphinx']['enabled'] = 1;

//分类
//$option['forums'] = empty($option['forums']) ? array() : filter_int($option['forums']);
$option['uids'] = isset($option['uids']) ? $option['uids'] : '';

$option['var_fields'] = array();

//开始构造select
$select = select();
$select->from($this_module->TABLE_ .$type, '*');

//排序
$str = $comma = '';
foreach($option['order_by'] as $field => $desc){
	if(!isset($order_bys[$field])) continue;
	
	$str .= $comma . $field .($desc == -1 ? '' : ($desc ? ' DESC' : ' ASC'));
	$comma = ',';
}

if($str){
	$select->order($str);
	$option['order_by_string'] = $str;
}

if($option['uids']){
	//多余的,
	$option['uids'] = filter_int(explode(',', $option['uids']));
	
	$select->in('uid', $option['uids']);
}


//限制
$select->limit(0, $option['limit']);


$_POST['option'] = $option;		//选项
