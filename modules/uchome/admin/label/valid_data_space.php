<?php
defined('PHP168_PATH') or die();

/**
* 数据过滤,将option中的选项存到数据库,同时也作SQL解析用
**/

//是否开启sphinx搜索功能
!empty($option['sphinx']) && $option['sphinx']['enabled'] = 1;

//分类
//$option['forums'] = empty($option['forums']) ? array() : filter_int($option['forums']);
//用户ID
if(!empty($option['uids'])){
		$option['uids'] = preg_replace('/[^0-9,]/', '', $option['uids']);
		$option['uids'] = filter_int(explode(',', $option['uids']));
		
}
$option['var_fields'] = array();

//开始构造select
$select = select();
$select->from($this_module->TABLE_ .$type, '*');

//非指定ID
if(empty($option['uids'])){
		
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
	if(!empty($option['usergroup'])){
			$option['usergroup'] = preg_replace('/[^0-9,]/', '', $option['usergroup']);
			$option['usergroup'] = filter_int(explode(',', $option['usergroup']));
			$select->in('usergroup', $option['usergroup']);
	}
	
	if(!empty($option['username'])){
			$option['username'] = filter_int(explode(',', $option['username']));
			$select->in('username', $option['username']);
	}
	//头像
	if(isset($option['avatar'])){
		$select->in('avatar', $option['avatar']);
	}//用户状态
	if(isset($option['flag'])){
		$select->in('flag', $option['flag']);
	}
}else{
		//指定ID,不需分页,不使用sphinx, 排序按传入ID的顺序排
		$select->in('uid', $option['uids']);

}

//限制
$select->limit(0, $option['limit']);


$_POST['option'] = $option;		//选项
