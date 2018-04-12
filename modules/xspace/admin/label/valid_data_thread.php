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
$select->from($this_module->TABLE_ .'forum_thread AS t', '*');
$select->range('t.displayorder', 0, null);

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
	
	if($option['forums']){
		//多余的,
		$option['forums'] = filter_int(explode(',', $option['forums']));
		
		$select->in('t.fid', $option['forums']);
	}
	
	//用户ID
	if(!empty($option['uids'])){
		
		$is_var = $controller->is_var_field($option['uids']);
		
		if(!empty($option['user_post'])){
			$select->inner_join($this_module->TABLE_ .'forum_post AS p', '', 'p.tid = t.tid');
			$field = 'p.authorid';
		}else{
			if(!$is_var){
				$option['uids'] = preg_replace('/[^0-9,]/', '', $option['uids']);
				//多余的,
				$option['uids'] = filter_int(explode(',', $option['uids']));
			}
			
			$field = 't.authorid';
		}
		
		if($is_var){
			$invoke[$field] = $option['uids'];
			$option['var_fields'][$field] = array('operator' => 'in', 'var' => $option['uids']);
			
			//生成缓存时要把ids项去掉
			$option['unset_options'][] = 'uids';
		}
		
		$select->in($field, $option['uids']);
	}
	
	//帖子类型
	if(!empty($option['types'])){
		
		//多余的,
		$option['types'] = filter_int(explode(',', $option['types']));
		
		$select->in('t.typeid', $option['types']);
	}
	
	//搜索关键字
	if(!empty($option['keyword'])){
		$select->search('t.subject', $option['keyword']);
	}
	
	//图片帖子
	if(!empty($option['image_thread'])){
		$select->in('t.attachment', 2);
	}
	
	//精华
	if(!empty($option['digest'])){
		$select->in('t.digest', $option['digest']);
	}
	
	//帖子类型
	if(!empty($option['thread_type'])){
		$select->in('t.special', $option['thread_type']);
	}
	
}else{
	
	//指定了ID其余的条件会被忽略
	
	$option['ids'] = filter_int(explode(',', $option['ids']));
	$select->in('t.tid', $option['ids']);
}

//限制
$select->limit(0, $option['limit']);


$_POST['option'] = $option;		//选项
