<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

load_language($this_system, 'admin');
$category = &$this_system->load_module('category');
$category->get_cache();
$cdata = $category->categories;
$answer = &$this_system->load_module('answer');
$keyword = isset($_POST['keyword'])?html_entities($_POST['keyword']):(isset($_GET['keyword'])?html_entities($_GET['keyword']):'');
$searchtype = isset($_POST['search_type'])?$_POST['search_type']:(isset($_GET['search_type'])?$_GET['search_type']:'');
$action = isset($_GET['action']) ? $_GET['action'] : '';
$url = $this_router . '-' . $ACTION . '?page=?page?';
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page = max(1, $page);

$select = select();
$select->from($this_module->table .' AS T', 'T.*');
if($keyword && $searchtype=='keyword')$select->like("T.title",$keyword);
if($keyword && $searchtype=='id')$select->in("T.id",$keyword);
switch($action){
	//已审核问题
	case 'verify':
		$select->in('T.verify', 1);
		$url .= '&action=verify';
		break;
	//未审核问题
	case 'not_verify':
		$select->in('T.verify', 0);
		$url .= '&action=not_verify';
		break;
	//已解决问题
	case 'solve':
		$select->in('T.status', 3);
		$url .= '&action=solve';
		break;
	//未解决问题
	case 'not_solve':
		$select->in('T.status', 3, true);
		$url .= '&action=not_solve';
		break;
	//悬赏问题
	case 'offercredit':
		$select->in('T.offercredit', 1);
		$url .= '&action=offercredit';
		break;
	//紧急问题
	case 'urgent':
		$select->in('T.urgent', 1);
		$url .= '&action=urgent';
		break;
	//推荐问题
	case 'recommend':
		$select->in('T.recommend', 1);
		$url .= '&action=recommend';
		break;
}

$select->order('T.id DESC');

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
	$list[$k]['url'] = p8_url($this_module, $list[$k], 'view');
	$list[$k]['status'] = $v['status']==3? 1 : 0;
}

$pages = list_page(array(
	'count' => $count,
	'page' => $page,
	'page_size' => 15,
	'url' => $url
));

include template($this_module, 'list', 'admin');