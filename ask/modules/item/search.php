<?php
defined('PHP168_PATH') or die();

$this_controller->check_action($ACTION) or message('no_privilege');

//载入分类模块
$category = $this_system->load_module('category');
$category->get_cache(true);

$page_url = $this_router . '-' . $ACTION;

$keyword = isset($_GET['keyword']) ? xss_clear(rawurldecode($_GET['keyword'])) : '';
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page = max(1, $page);

$select = select();
$select->from($this_module->table . ' AS T', 'T.*');
$select->inner_join($this_module->table_data . ' AS D', 'D.content', 'D.id=T.id');
$select->inner_join($category->table . ' AS C','C.name AS category_name', 'T.cid=C.id');
$select->in('T.verify', 1);
$select->in('C.display', 1);

if($filter == 'solve'){
	$select->in('T.status', 3);
}
elseif($filter == 'unsolved'){
	$select->in('T.status', 3, true);
}

if(empty($keyword)){
	$select->order('T.id DESC');
}else{
	$select->like('T.title', p8_addslashes($keyword));
	$select->order('T.addtime DESC');
}

$count = 0;
$page = min($page, 500);
$list = $core->list_item(
	$select,
	array(
		'page' => &$page,
		'count' => &$count,
		'page_size' => intval($this_system->CONFIG['search_perpage'])
	)
);

foreach($list as $key=>$value){
	$list[$key]['url'] = p8_url($this_module, $list[$key], 'view');
	$location_categories = '';
	$parent_categories = $category->get_parents($list[$key]['cid']);
	//问题所在的分类
	foreach($parent_categories as $k=>$v){
		$location_categories .= '<a href="' . $category->categories[$v['id']]['url'] . '" target="_blank">' . $category->categories[$v['id']]['name'] . '</a>&nbsp;&gt;&nbsp;';
	}
	$list[$key]['category'] = $location_categories . '<a href="' . $category->categories[$value['cid']]['url'] . '" target="_blank">' . $category->categories[$list[$key]['cid']]['name'] .'</a>';
}

$page_url .= '?keyword=' . rawurlencode($keyword) . '&filter=' . $filter . '&page=' . $page;
$pages = list_page(array(
	'count' => $count, 
	'page' => $page, 
	'page_size' => intval($this_system->CONFIG['search_perpage']), 
	'url' => $page_url, 
	'layout_size' => intval($this_system->CONFIG['search_layout_size']), 
	'template' => $P8LANG['ask_common_page_template']
));

$position = $this_system->position . '&nbsp;&gt;&nbsp;' . $P8LANG['ask_search_result'];

//网站标题
$sitename = $this_system->sitename . ' - ' . $this_system->sitetitle;
$meta_keywords = $keyword . ($keyword ? ',' : '') . $this_system->meta_keywords;
$meta_description = $keyword . ($keyword ? ',' : '') . $this_system->meta_description;

include template($this_module, 'search');