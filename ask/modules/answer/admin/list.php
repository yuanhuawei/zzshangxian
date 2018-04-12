<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

load_language($this_system, 'admin');

//载入问题模块
$item = &$this_system->load_module('item');
$item_controller = &$core->controller($item);

$action = isset($_GET['action']) ? $_GET['action'] : '';
$url = $this_router . '-' . $ACTION . '?page=?page?';
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page = max(1, $page);

$select = select();
$select->from($this_module->table .' AS A', 'A.*');	
$select->left_join($this_module->table_data . ' AS D', 'D.content', 'D.id=A.id');
$select->left_join($item->table .' AS T', 'T.title', 'A.tid = T.id');

//传递问题ID
$header_url = '';
$tid = isset($_GET['tid']) ? intval($_GET['tid']) : 0;
if($tid && $item_controller->check_exists(array('id'=>$tid))){
	$select->in('A.tid', $tid);
	$url .= "?tid=$tid";
	$header_url = "?tid=$tid";
}

switch($action){
	//已审核答案
	case 'verify':
		$select->in('A.verify', 1);
		$url .= '&action=verify';
		break;
	//未审核
	case 'not_verify':
		$select->in('A.verify', 0);
		$url .= '&action=not_verify';
		break;
	//最佳答案
	case 'bestanswer':
		$select->in('A.bestanswer', 1);
		$url .= '&action=bestanswer';
		break;
}

$select->order('A.id DESC');

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
	$list[$k]['content'] = p8_cutstr(strip_tags(html_decode_entities($list[$k]['content'])),30);
	$list[$k]['title'] = p8_cutstr(strip_tags(html_decode_entities($list[$k]['title'])),30);
}

$pages = list_page(array(
	'count' => $count,
	'page' => $page,
	'page_size' => 15,
	'url' => $url
));

include template($this_module, 'list', 'admin');