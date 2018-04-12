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
$option['thread_type'] = isset($option['thread_type']) ? array_map('intval', $option['thread_type']) : array(0);
$option['digest'] = isset($option['digest']) ? filter_int($option['digest'], true) : array();
$option['keyword'] = isset($option['keyword']) ? $option['keyword'] : '';
$option['var_fields'] = array();

//开始构造select
$select = select();
$select->from($this_module->TABLE_ .$type, '*');

//非指定ID
if(empty($option['ids'])){
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
	
	if($option['username']){
		$option['username'] = explode(',', $option['username']);
		$select->in('username', $option['forums']);
	}
	//发布时间
	if(!empty($option['dateline'])){
			$select->range('dateline', P8_TIME-$option['dateline']);
		}
	//用户ID
	if(!empty($option['uids'])){
			$option['uids'] = preg_replace('/[^0-9,]/', '', $option['uids']);
			$option['uids'] = filter_int(explode(',', $option['uids']));
	}
	
	//搜索关键字
	if(!empty($option['subject'])){
		$select->search('subject', $option['subject']);
	}
		
}else{
	
	//指定了ID其余的条件会被忽略
	
	$option['ids'] = filter_int(explode(',', $option['ids']));
	$select->in('id', $option['ids']);
}

//限制
$select->limit(0, $option['limit']);


$_POST['option'] = $option;		//选项
