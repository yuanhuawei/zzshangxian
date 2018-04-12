<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

load_language($this_system, 'admin');

//载入问题模块
$item = &$this_system->load_module('item');

$url = $this_router . '-' . $ACTION . '?page=?page?';
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page = max(1, $page);

$select = select();
$select->from($this_module->table, '*');
$select->in('parent', 0);
$select->order('display_order DESC,id DESC ');

$count = 0;
$list = $core->list_item(
	$select, 
	array(
		'page' => &$page,
		'count' => &$count,
		'page_size' => 20
	)
);

//二级分类
$second_categories = $this_module->get_second();

foreach($list as $k=>$v){
	$list[$k]['categories'] = array();
	//二级分类总数小于60时显示
	if(count($second_categories)<=60 && array_key_exists('categories',$this_module->categories[$list[$k]['id']])){
		$categories = $this_module->categories[$list[$k]['id']]['categories'];
		if(!empty($categories)){
			foreach($categories as $value){
				$list[$k]['categories'][] = $value;				
			}
		}		
	}
}

$pages = list_page(array(
	'count' => $count,
	'page' => $page,
	'page_size' => 20,
	'url' => $url
));

include template($this_module, 'list', 'admin');