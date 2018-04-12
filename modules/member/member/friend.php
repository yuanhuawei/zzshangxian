<?php
defined('PHP168_PATH') or die();

/**
* 好友管理
**/

if(REQUEST_METHOD == 'GET'){
	
	isset($_GET['verified']) || $_GET['verified'] = 1;
	$verified = empty($_GET['verified']) ? 0 : 1;
	$cid = isset($_GET['cid']) ? intval($_GET['cid']) : 0;
	
	$T = $verified ? $this_module->friend_table : $this_module->unverified_friend_table;
	
	$select = select();
	$select->from($T .' AS f', 'f.fuid, f.cid, f.timestamp, description');
	$select->inner_join($this_module->table .' AS m', 'm.id, m.username', 'f.fuid = m.id');
	$select->in('f.uid', $UID);
	if($cid)
		$select->in('f.cid', $cid);
	
	if($verified){
		$query = $DB_slave->query("SELECT id, name, members FROM $this_module->friend_category_table WHERE uid = '$UID'");
		$categories = array();
		while($arr = $DB_slave->fetch_array($query)){
			$categories[$arr['id']] = $arr;
			unset($categories[$arr['id']]['id']);
		}
	}
	
	$count = 0;
	$page = 0;
	$list = $core->list_item(
		$select,
		array(
			'count' => &$count,
			'page' => &$page
		)
	);
	
	if(P8_AJAX_REQUEST){
		//AJAX jsonp请求
		$callback = isset($_GET['callback']) ? $_GET['callback'] : '';
		
		$json = array(
			'friends' => &$list,
			'categories' => &$categories
		);
		
		exit($callback .'('. jsonencode($json) .');');
		
	}else{
		//语言包
		load_language($this_module, 'friend');
		
		include template($this_module, 'friend_list');
	}
	
}