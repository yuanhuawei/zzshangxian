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
$option['usergroup'] = isset($option['usergroup']) ? $option['usergroup'] : '';
$option['qq'] = isset($option['qq']) ? $option['qq'] : '';
$option['var_fields'] = array();

//开始构造select
$select = select();
$select->from($this_module->TABLE_ .'common_member AS m', 'm.*');

//非指定ID
if(empty($option['ids'])){
		
		if($option['qq']){
			$select->inner_join($this_module->TABLE_ .'common_member_profile AS mp', 'mp.*', 'm.uid = mp.uid');
			$select->in('mp.qq', $option['qq']);
		}
		
		if(!empty($option['usergroup'])){
			$select->in('m.groupid', $option['usergroup']);
		}
		
		//排序
		if(!empty($option['order_by_string'])){
			$select->order($option['order_by_string']);
		}
		
		$page = 0;
		//总记录数
		$count = 0;
		$page_size = $option['limit'];
		
		$list = $this_module->core->list_item(
			$select,
			array(
				'page' => &$page,
				'page_size' => $page_size,
				'count' => &$count,
				'db_obj' => &$this_module->db,
			)
		);
		/*if(!empty($option['qq_online'])){
			$tmp = p8_http_request(array('url' => 'http://webpresence.qq.com/getonline?Type=1&'. implode(':', $option['qq'])));
		}*/
	}else{
		//指定ID,不需分页,不使用sphinx, 排序按传入ID的顺序排
		$select->in('m.uid', $option['ids']);
		$c = range(0, count($option['ids']) -1);
		
		$list = $this_module->core->list_item(
			$select,
			array(
				'page_size' => 0,
				'db_obj' => &$this->db,
			)
		);
		
		$tmp = array_combine($option['ids'], $c);
		foreach($list as $v){
			$tmp[$v['uid']] = $v;
		}
		
		$list = array_values($tmp);
	}

//限制
$select->limit(0, $option['limit']);


$_POST['option'] = $option;		//选项
