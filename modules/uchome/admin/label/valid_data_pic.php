<?php
defined('PHP168_PATH') or die();

/**
* 数据过滤,将option中的选项存到数据库,同时也作SQL解析用
**/

//是否开启sphinx搜索功能
!empty($option['sphinx']) && $option['sphinx']['enabled'] = 1;

//分类
//$option['forums'] = empty($option['forums']) ? array() : filter_int($option['forums']);
$option['ids'] = isset($option['ids']) ? $option['ids'] : '';
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
		$select->in('username', $option['username']);
	}

	if(!empty($option['albumid'])){
		$option['albumid'] = preg_replace('/[^0-9,]/', '', $option['albumid']);
		$option['albumid'] = filter_int(explode(',', $option['albumid']));
		$select->in('albumid', $option['albumid']);
	}
	//用户ID
	if(!empty($option['uids'])){
			$option['uids'] = preg_replace('/[^0-9,]/', '', $option['uids']);
			$option['uids'] = filter_int(explode(',', $option['uids']));
			$select->in('uid', $option['uids']);
	}

}else{
		
	//指定了ID其余的条件会被忽略
	
	$option['ids'] = filter_int(explode(',', $option['ids']));
	$select->in('picid', $option['ids']);
}

//限制
$select->limit(0, $option['limit']);


$_POST['option'] = $option;		//选项
