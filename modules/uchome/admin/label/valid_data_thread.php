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

	//用户ID
	if(!empty($option['uids'])){
			$option['uids'] = preg_replace('/[^0-9,]/', '', $option['uids']);
			$option['uids'] = filter_int(explode(',', $option['uids']));
			$select->in('uid', $option['uids']);
	}
	
	//发布时间
	if(!empty($option['dateline'])){
		$select->range('dateline', P8_TIME-$option['dateline']);
	}
	//更新时间
	if(!empty($option['updatetime'])){
		$select->range('updatetime', P8_TIME-$option['updatetime']);
	}
	//隐私范围
	if(isset($option['friend'])){
		$select->in('friend', $option['friend']);
	}
	//群组ID
	if(isset($option['tagid'])){
		$option['tagid'] = preg_replace('/[^0-9,]/', '', $option['tagid']);
		$option['tagid'] = filter_int(explode(',', $option['tagid']));
		$select->in('tagid', $option['tagid']);
	}
	
}else{
		//指定ID,不需分页,不使用sphinx, 排序按传入ID的顺序排
		$select->in('threadid', $option['ids']);

}

//限制
$select->limit(0, $option['limit']);


$_POST['option'] = $option;		//选项
