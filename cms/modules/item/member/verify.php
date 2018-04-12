<?php
defined('PHP168_PATH') or die();

$this_controller->check_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){

$MODEL = '';

if(isset($_REQUEST['model'])) $this_system->init_model();

$MODEL && load_language($this_module, $MODEL);

$page_url = $this_router .'-'. $ACTION .'?';

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page = max($page, 1);
$cid = isset($_GET['cid']) ? intval($_GET['cid']) : 0;
$keyword = isset($_GET['keyword']) ? ltrim($_GET['keyword']) : '';

if(isset($_GET['verified'])){
	$verified = intval($_GET['verified']);
	$T = $verified == 1 ? $this_module->main_table : $this_module->unverified_table;
	
}else{
	$verified = 1;
	$T = $this_module->main_table;
}
$class[abs($verified)]='class="over"';
$page_url .= '&verified='. $verified;
$page_url .= '&model='. $MODEL;
$page_url .= '&cid='. $cid;
$page_url .= '&keyword='. urlencode($keyword);
$page_url .= '&page=?page?';
$select = select();

$my_category_to_verify = $this_controller->get_acl('my_category_to_verify');

$category = &$this_system->load_module('category');
$category->get_cache();

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

if(isset($my_category_to_verify[0]) || $IS_FOUNDER){
	if($cid)$select->in('i.cid',$cid);
}elseif(!empty($my_category_to_verify)){
	$my_category_to_verify =array_keys($my_category_to_verify);
	if($cid && in_array($cid, $my_category_to_verify))$select->in('i.cid', $cid);
	else $select->in('i.cid', $my_category_to_verify);

}else{
message('no_privilege');
}
$select->order('i.id DESC');

//所有模型
$models = $this_system->get_models();

$count = 0;
//echo $select->build_sql();
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
		$list[$k]['title']=p8_cutstr($list[$k]['title'],66);
		$list[$k]['url'] = p8_url($this_module, $v, 'view');
		$list[$k]['url'] .= $verified == 1? '' : '?verified=0';
}
//分页
$pages = list_page(array(
	'count' => $count,
	'page' => $page,
	'page_size' => 20,
	'url' => $page_url
));

	include template($this_module, 'verify');
	
}else if(REQUEST_METHOD == 'POST'){
	//只提供AJAX调用
	
	$id = isset($_POST['id']) ? $_POST['id'] : array();
	$value = isset($_POST['value']) ? intval($_POST['value']) : 0;
	$id or message('no_such_item');
	
	$id = filter_int($id);
	$id or exit('[]');
	
	$verified = isset($_POST['verified']) && $_POST['verified'] == 1 ? 1 : 0;
	//退稿理由
	$push_back_reason = isset($_POST['push_back_reason']) ? html_entities(from_utf8($_POST['push_back_reason'])) : '';
	
	$T = $value == 1 ? $this_module->unverified_table : $this_module->main_table;
	$T = $verified ? $this_module->main_table : $this_module->unverified_table;
	
	$cond = $T .'.id IN ('. implode(',', $id) .')';
	$ret = $this_controller->verify(array(
		'where' => $cond,
		'value' => $value,
		'verified' => $verified,
		'push_back_reason' => $push_back_reason
	))or exit('[]');
	exit(jsonencode($ret));
}