<?php
defined('PHP168_PATH') or die();

/**
* 查看投票者
**/
$this_controller->check_action($ACTION) or message('no_privilege');
if(REQUEST_METHOD == 'GET'){
	
	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	$id or message('no_such_item');
	
	$data = $CACHE->read($SYSTEM .'/modules/'. $MODULE, 'vote', $id, 'serialize');
	
	$oid = isset($_GET['oid']) ? intval($_GET['oid']) : 0;
	
	if(empty($data['options'][$oid])) message('no_such_vote_option');
	
	$view_result = $this_controller->check_action('view_result');

	//不允许查看投票者,分配有权限或者创始人例外
	if((empty($data['view_voter']) || !$view_result || empty($data['viewable'])) && !$IS_FOUNDER){
		message('not_allow_to_view_voter');
	}else if(!empty($data['vote_to_view']) && !SE_ROBOT){
		//投票后才允许查看
		$check = $DB_slave->fetch_one( "SELECT timestamp FROM $this_module->voter_table WHERE vid = '$id' AND ". ($UID ? " uid = '$UID'" : " uid = '". P8_IP ."'") );
		
		if(empty($check['timestamp'])) message('vote_to_view', $this_router .'-vote?id='. $id);
		
	}
	
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page = max(1, $page);
	
	$select = select();
	$select->from($this_module->voter_table, '*');
	$select->in('oid', $oid);
	$select->order('timestamp ASC');
	
	$page_size = 20;
	
	$page_url = $this_url .'?id='. $id .'&oid='. $oid .'&page=?page?';
	
	$list = $core->list_item(
		$select,
		array(
			'count' => $data['options'][$oid]['votes'],
			'page' => &$page,
			'page_size' => $page_size
		)
	);
	//print_r($list);
	
	$pages = list_page(array(
		'count' => $data['options'][$oid]['votes'],
		'page' => $page,
		'page_size' => $page_size,
		'url' => $page_url
	));
	
	include template($this_module, 'voter');
	
}