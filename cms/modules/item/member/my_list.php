<?php
defined('PHP168_PATH') or die();

if(!empty($_REQUEST['model'])){
	$this_system->init_model();
	
	$this_model or message('no_such_cms_model');
}else{
	$MODEL = '';
}

//$this_controller->check_action($ACTION) or message('no_privilege');

//加载分类模块
$category = &$this_system->load_module('category');
$category->get_cache();

$page_url = $this_router .'-'. $ACTION .'?';

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page = max($page, 1);
$cid = isset($_GET['cid']) ? intval($_GET['cid']) : 0;
$mine = empty($_GET['mine']) ? 0 : 1;
if(isset($_GET['verified'])){
	$verified = intval($_GET['verified']);
	$T = $this_module->unverified_table;
}else{
	$verified = 1;
	$T = $this_module->main_table;
}
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

$holder = '';
$page_url .= '&model='. $MODEL;
$holder .= '&model='. $MODEL;
$page_url .= '&cid='. $cid;
$holder .= '&cid='. $cid;
$page_url .= '&keyword='. urlencode($keyword);
$holder .= '&keyword='. urlencode($keyword);
$page_url .= '&mine='. $mine;
$holder .= '&mine='. $mine;
$page_url .= '&verified='. $verified;
$holder .= '&verified='. $verified;
$page_url .= '&page=?page?';
$holder .= '&page='. $page;

$holder = urlencode($holder);

$select = select();
$select->in('i.uid', $UID);

if($verified == 1){
	if($MODEL){
		$select->from($this_module->table .' AS i', 'i.*');
	}else{
		$select->from($this_module->main_table .' AS i', 'i.*');
	}
}else{
	$select->from($T .' AS i', 'i.*');
	$select->in('i.verified', $verified);
}

$class[abs($verified)]='class="over"';	
if($cid){
	$category->get_cache();
	$ids = array($cid) + $category->get_children_ids($cid);
	
	$select->in('i.cid', $ids);
	$select->order('i.timestamp DESC');
}else{
	$select->order('i.id DESC');
}


if(strlen($keyword)){
	$select->like('i.title', $keyword);
}
$select->inner_join($this_system->category_table .' AS c', 'c.name AS category_name', 'c.id = i.cid');

//所有模型
$models = $this_system->get_models();
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
foreach($list as $k => $v){
		$list[$k]['url'] = $core->controller.'/cms/item-view-id-'.$v['id'];
		$list[$k]['url'] .= $verified == 1? '' : '?verified=0';
		$list[$k]['title'] = p8_cutstr($list[$k]['title'],90);
}
//分页
$pages = list_page(array(
	'count' => $count,
	'page' => $page,
	'page_size' => 20,
	'url' => $page_url
));


	include template($this_module, 'my_list');
