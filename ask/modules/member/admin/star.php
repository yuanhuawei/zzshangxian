<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

load_language($this_system, 'admin');
//载入分类模块
$category = &$this_system->load_module('category');
$json = $category->get_json();
$url = $this_router . '-' . $ACTION . '?page=?page?';
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page = max(1, $page);

$select = select();
$select->from($this_module->table .' AS M', 'M.*');
$select->in('M.star', 1);
$select->order('M.id DESC');

$count = 0;
$list = $core->list_item(
	$select,
	array(
		'page' => &$page,
		'count' => &$count,
		'page_size' => 15
	)
);

foreach($list as $k=>$v){
	if($list[$k]['expert']){
		$list[$k]['categories'] = $this_controller->get_expertor_category(array('id'=>$list[$k]['id']), false);
	}
}
	
$pages = list_page(array(
	'count' => $count,
	'page' => $page,
	'page_size' => 15,
	'url' => $url
));

include template($this_module, 'list', 'admin');
