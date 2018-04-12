<?php
defined('PHP168_PATH') or die();

$this_controller->check_action($ACTION) or message('no_privilege');

if(empty($UID)){
	message('not_login');
}

$filter = $page_url = '';
$list = array();
$page = 1;
$count = 0;

//载入分类模块
$category = &$this_system->load_module('category');
$category->get_cache();

foreach($URL_PARAMS as $k=>$v){
	switch($v){
		case 'filter':
			$filter = isset($URL_PARAMS[$k+1]) ? $URL_PARAMS[$k+1] : '';
			break;
		case 'page':
			$page = isset($URL_PARAMS[$k+1]) ? intval($URL_PARAMS[$k+1]) : 1;
			$page = max(1, $page);
			break;
	}
}

$select = select();
$select->from($this_module->table . ' AS I', 'I.*');
$select->in('I.uid', $UID);
//未解决
if($filter == 'unsolved'){
	$select->in('I.status', 3, true);
	$select->in('I.verify', 1);
	$select->order('I.id DESC');
}
//已解决
elseif($filter == 'solve'){
	$select->in('I.status', 3);
	$select->order('I.solvetime DESC');
}
//推荐
elseif($filter == 'recommend'){
	$select->in('I.recommend', 1);
	$select->order('I.lastpost DESC');
}
//未审核
elseif($filter == 'not_verify'){
	$select->in('I.verify', 0);
	$select->order('I.addtime DESC');
}
else{
	$select->order('I.id DESC');
}


$list = $core->list_item(
	$select,
	array(
		'page' => &$page,
		'count' => &$count,
		'page_size' => intval($this_system->CONFIG['perpage'])
	)
);

foreach($list as $k=>$v){
	$list[$k]['url'] = p8_url($this_module, $list[$k], 'view');
}

$pages = list_page(array(
	'count' => $count,
	'page' => $page, 
	'page_size' => intval($this_system->CONFIG['perpage']), 
	'url' => $this_router.'-'.$ACTION.'-page-?page?-filter-'.$filter,
	'layout_size' => intval($this_system->CONFIG['layout_size']), 
	'template' => $P8LANG['ask_page_template']
));

include template($this_module, 'my_ask');