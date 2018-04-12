<?php
defined('PHP168_PATH') or die();
$cid = 0;
$page = 1;
foreach($URL_PARAMS as $k => $v){
	switch($v){
		case 'id':
			$cid = isset($URL_PARAMS[$k +1]) ? intval($URL_PARAMS[$k +1]) : 0;
			$PAGE_CACHE_PARAM['id'] = $id;
			break;
		case 'page':
		$page = isset($URL_PARAMS[$k +1]) ? intval($URL_PARAMS[$k +1]) : 1;
		$page = max($page, 1);
		break;
	}
}
//检查权限
if(!$this_controller->check_action('view')){
	message('no_privilege');
	return;
}

//检查是否可以留言
$guestbook =$this_controller->check_action('guestbook');

//检查是否可以审核
$verify =$this_controller->check_action('verify');
//检查是否可以回复
$reply =$this_controller->check_action('reply');
//检查是否可以修改
$edit =$this_controller->check_action('edit');
//检查是否可以删除
$delete =$this_controller->check_action('delete');

//预填资料
	$member = &$core->load_module('member');
	$member->set_model($ROLE_GROUP);
	$data=$member->get_member_info($UID);
$this_module->get_cache();
//print_r($this_module->categories);
$category = $this_module->categories;
//sizeof($category)>1 && array_unshift($category,array('id'=>0,'name'=>$P8LANG['default']));
if($category && !$cid){
//默认第一个分类
	$first=array_shift($this_module->categories);
	$cid=$first['id'];
}
if($cid)$over[$cid]='over';

	$select = select();
	$page_url = $this_router.'-main-id-'.$cid.'-page-?page?';
	$select->from($this_module->table .' AS i', 'i.*');
	if($cid){
		$select->in('i.cid', $cid);
	}
	$select->in('i.ifhide', 1,true);
	if(!$verify)
	$select->in('i.verified', 1);
	
	$select->order('i.id DESC');

	//echo $select->build_sql();
	$page_size=!empty($this_module->CONFIG['GuestBookList'])?$this_module->CONFIG['GuestBookList']:10;
	$count = 0;
	//取数据
	$list = $core->list_item(
		$select,
		array(
			'page' => &$page,
			'count' => &$count,
			'page_size' => $page_size,
			'ms' => 'master'
		)
	);
	$list = $this_controller->format_data($list);
	//分页
	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => $page_size,
		'url' => $page_url
	));
	
//初始化标签
$LABEL_POSTFIX = array();
//如果分类有自己的标签后缀
array_push($LABEL_POSTFIX, 'gb_cid_'.$cid);	

include template($this_module, 'list');

?>