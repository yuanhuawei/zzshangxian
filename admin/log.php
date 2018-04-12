<?php
defined('PHP168_PATH') or die();

/**
* 日志管理
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	load_language($core, 'config');
	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	if($id){
		$data = $DB_master->fetch_one("SELECT data FROM {$core->TABLE_}admin_log WHERE id = '$id'");
		
		exit(html_entities($data['data']));
	}
	
	$uid = isset($_GET['uid']) ? intval($_GET['uid']) : 0;
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$desc = empty($_GET['desc']) ? ' DESC' : ' ASC';
	$keyword = isset($_GET['keyword']) ? p8_stripslashes2(trim($_GET['keyword'])) : '';
	$username = isset($_GET['username']) ? trim($_GET['username']) : '';
	$system = isset($_GET['system']) ? $_GET['system'] : '';
	$module = isset($_GET['module']) ? trim($_GET['module']) : '';

	$page = max($page, 1);
	
	$select = select();
	$select->from($core->TABLE_ .'admin_log', 'id, uid, username, title, url, ip, timestamp');
	$select->order('id'. $desc);
	if($uid){
		$select->in('uid', $uid);
		$select->order('timestamp'. $desc);
	}
	$select->where_and();
	
	$kw = array();
	if($keyword) {
		$kw = explode('/',$keyword);
		$select->like(count($kw)==2 ? 'title' : 'url', count($kw)==2 ? '/'.$kw[1]:'/'.$kw[1].'/'.$kw[2]);		
	}
	if($username) $select->in('username', $username);
	
	$list_systems = $core->list_systems();
	$enable_systems = array(0=>'core');
	foreach($list_systems as $key=>$val){
		if($val['installed'] && $val['enabled']) $enable_systems[] = $key;		
	}
	$list_modules = array();
	if($system || $keyword && in_array($kw[1],$enable_systems)){
		if($system == 'core' || $keyword && $kw[1]=='core'){
			$system = 'core';
			$list_modules = &$core->list_modules();			
		}else{
			$system = $system ? $system : $kw[1];
			$this_system = &$core->load_system($system);
			$list_modules = $this_system->list_modules();
		}
		if($system && in_array($system,$enable_systems)) $select->like('url', '/'.$system);
	}
	$count = 0;
	$page_size = 20;
	$list = $core->list_item(
		$select,
		array(
			'page' => &$page,
			'count' => &$count,
			'page_size' => $page_size
		)
	);
	//echo $select->build_sql();
	$page_url = $this_url .'?page=?page?';
	if($keyword) $page_url .= '&keyword=?keyword?';
	if($username) $page_url .= '&username=?username?';
	
	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'keyword' => $keyword,
		'username' => $username,
		'page_size' => $page_size,
		'url' => $page_url
	));
	
	include template($core, 'log', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$act = isset($_POST['act']) ? $_POST['act'] : '';
	switch($act){
	
	case 'truncate':
		$DB_master->query("TRUNCATE TABLE {$core->TABLE_}admin_log");
		
		$ADMIN_LOG = array('title' => $P8LANG['_core_truncate_admin_log']);
		
		message('done');
	break;
	
	case 'delete':
		$id = isset($_POST['id']) ? filter_int($_POST['id']) : array();
		$id or message('access_denied');
		
		$DB_master->delete(
			$core->TABLE_ .'admin_log',
			'id IN ('. implode(',', $id) .')'
		);
		
		$ADMIN_LOG = array('title' => $P8LANG['_core_delete_admin_log']);
		
		message('done');
	break;
	
	}
	
}