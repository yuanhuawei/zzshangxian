<?php
defined('PHP168_PATH') or die();

/**
* 内容管理
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');


$sphinx = $this_module->CONFIG['sphinx'];
$use_sphinx = false;

if(!empty($_REQUEST['model'])){
	$this_system->init_model();
	$sphinx['index'] = $this_system->sphinx_indexes(array($MODEL => 1));
	
	$this_model or message('no_such_cms_model');
}else{
	$MODEL = '';
	$sphinx['index'] = $this_system->sphinx_indexes();
}

//加载分类模块
$category = &$this_system->load_module('category');

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page = max($page, 1);
$cid = isset($_GET['cid']) ? intval($_GET['cid']) : 0;
$mine = empty($_GET['mine']) ? 0 : 1;
$desc = empty($_GET['order']) ? ' DESC' : ' ASC';
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
$username = isset($_GET['username']) ? trim($_GET['username']) : '';
$verifier = isset($_GET['verifier']) ? trim($_GET['verifier']) : '';
$id = isset($_GET['id']) ? filter_int(explode(',', $_GET['id'])) : '';

if(isset($_GET['verified'])){
	$verified = intval($_GET['verified']);
	$T = $verified == 1 ? $this_module->main_table : $this_module->unverified_table;
	
}else{
	$verified = 1;
	$T = $this_module->main_table;
	
}

if(!P8_AJAX_REQUEST){
	
	
	//所有模型
	$models = $this_system->get_models();
	//模型JSON
	$model_json = p8_json($models);
	//分类JSON
	$category_json = $category->get_json();
	//属性JSON
	$attributes = array();
	foreach($this_module->attributes as $aid => $lang){
		$attributes[$aid] = $P8LANG['cms_item']['attribute'][$aid];
	}
	$attr_json = p8_json($attributes);
	
	$clustered = $core->clustered && $this_controller->check_admin_action('cluster_push');
    $sites_push =  $this_controller->check_admin_action('cluster_push') && isset($core->systems['sites']) && $core->systems['sites']['installed'];
	
	$allow_update = $this_controller->check_admin_action('update');
	$allow_delete = $this_controller->check_admin_action('delete');
	$allow_verify = $this_controller->check_admin_action('verify');
	$allow_move = $this_controller->check_admin_action('move');
	$allow_attribute = $this_controller->check_admin_action('attribute');
	$allow_add = $this_controller->check_admin_action('add');
	$allow_list_order = $this_controller->check_admin_action('list_order');
	$allow_view_to_html = $this_controller->check_admin_action('view_to_html');
	$allow_clone = $this_controller->check_admin_action('clone');
	
	include template($this_module, 'list', 'admin');
	exit;
}else{
	//JS传过来的关键字,UTF-8的
	$keyword = from_utf8($keyword);
	$username = from_utf8($username);
	$verifier = from_utf8($verifier);
}


$page_url = $this_url .'?';
$page_url = 'javascript:request_item(?page?)';





$select = select();
$fields = 'i.id, i.model, i.title, i.title_color, i.title_bold, i.cid, i.url, i.uid, i.username, i.attributes, i.pages, i.views, i.comments, i.verified,i.verifier, i.timestamp, i.list_order';
$u_fields = 'i.id, i.cid, i.model, i.title, i.username, i.timestamp, i.push_back_reason, i.attributes, i.pages, i.verified, i.views, i.comments';

if($id){
	
	$select->from($T .' AS i', $fields);
	$select->in('i.id', $id);
	
}else if($mine){
	
	if($verified == 1){
		$use_sphinx = true;
		$u_fields = $fields;
	}
	
	//我发表的
	$select->from($T .' AS i', $u_fields);
	$select->inner_join($this_module->member_table .' AS m', 'm.uid', 'i.id = m.iid');
	if($cid){
		$category->get_cache();
		$ids = array($cid) + $category->get_children_ids($cid);
		
		$select->in('i.cid', $ids);
	}
	
	$select->in('m.uid', $UID);
	$verified == -99 || $select->in('i.verified', $verified);
	$verified == 0 || $select->in('i.verified', $verified);
	$select->order('m.timestamp'. $desc);
	
}else{
	
	if($verified == 1){
		if($MODEL){
			$select->from($this_module->table .' AS i', $fields);
		}else{
			$select->from($this_module->main_table .' AS i', $fields);
		}
		
	}else{
		$select->from($T .' AS i', $u_fields);
		$verified == -99 || $select->in('i.verified', $verified);
		$verified == 0 || $select->in('i.verified', $verified);
		if($MODEL){
			$select->in('i.model', $MODEL);
		}
		
		//我能审核的分级
		/*$levels = array(-99, 0);
		foreach($this_module->CONFIG['verify_acl'] as $level => $v){
			if(!empty($v['role'][$this_system->ROLE])){
				$levels[] = $level;
			}
		}
		
		$select->in('i.status', $levels);
		*/
		
		
		//我能审核的栏目
		$my_cats = $this_controller->get_acl('my_category_to_verify');
		$all = isset($my_cats[0]); unset($my_cats[0]);
		if(!$all || !empty($my_cats) || !$IS_FOUNDER){
			$cids = array_keys((array)$my_cats);
			$select->in('i.cid', $cids);
		}
		
	}
	
	if($cid){
		$category->get_cache();
		$ids = array($cid) + $category->get_children_ids($cid);
		
		$select->in('i.cid', $ids);
		$select->order('i.list_order'. $desc);
		
		$use_sphinx = $verified == 1 ? true : false;
	}else{
		$select->order('i.id'. $desc);
	}
	
	if($verified != 1){
		$select->order('i.id'. $desc);
	}
	
}
$select->left_join($this_system->category_table .' AS c', 'c.name AS category_name', 'c.id = i.cid');

if(strlen($keyword)){
	$use_sphinx = $verified == 1 ? true : false;
	$select->search('i.title', $keyword);
}
if(strlen($username)){
	$use_sphinx = $verified == 1 ? true : false;
	$select->search('i.username', $username);
}
if(strlen($verifier)){
	$use_sphinx = $verified == 1 ? true : false;
	$select->search('i.verifier', $verifier);
}

$page_size = 40;
$count = 0;
//取数据
$list = $core->list_item(
	$select,
	array(
		'page' => &$page,
		'count' => &$count,
		'page_size' => $page_size,
		'ms' => 'master',
		'sphinx' => $use_sphinx && $sphinx['enabled'] ? $sphinx : null
	)
);

//echo $select->build_sql();exit;

echo p8_json(array(
	'list' => $list,
	'pages' => list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => $page_size,
		'url' => $page_url
	)),
	'time' => get_timer() - $P8['start_time'],
	'sphinx' => $sphinx
));

exit;