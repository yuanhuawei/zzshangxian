<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action('edit') or message('no_privilege');

$json = $this_module->category->get_json();
$this_module->category->get_cache(true);
$page_url = $this_url .'?';

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page = max($page, 1);
$cid = isset($_GET['cid']) ? intval($_GET['cid']) : 0;
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

$holder = '';
$page_url .= '&cid='. $cid;
$holder .= '&cid='. $cid;
$page_url .= '&keyword='. urlencode($keyword);
$holder .= '&keyword='. urlencode($keyword);
$page_url .= '&page=?page?';
$holder .= '&page='. $page;

$holder = urlencode($holder);

$select = select();



$select->from($this_module->table .' AS i', 'i.*');
if($cid){
	$ids = array($cid) + $this_module->category->get_children_ids($cid);
	
	$select->in('i.cid', $ids);
	$select->order('i.timestamp DESC');
}else{
	$select->order('i.id DESC');
}

if(strlen($keyword)){
	$select->like('i.title', $keyword);
}

//echo $select->build_sql();
$count = 0;
//取数据
$list = $core->list_item(
	$select,
	array(
		'page' => &$page,
		'count' => &$count,
		'page_size' => 20,
		'ms' => 'master'
	)
);

//分页
$pages = list_page(array(
	'count' => $count,
	'page' => $page,
	'page_size' => 20,
	'url' => $page_url
));

include template($this_module, 'list', 'admin');

