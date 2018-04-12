<?php

/**
* 查看广告投放记录
**/

message('暂不开放');

if(REQUEST_METHOD == 'GET'){
	
	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	$id or message('no_such_item');
	
	$ad = $this_module->get($id);
	if(empty($ad['buyable'])) message('no_such_item');
	
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	$page = max(1, $page);
	
	$select = select();
	$select->from($this_module->buy_table, '*');
	$select->in('aid', $id);
	$select->order('display_order ASC, timestamp ASC');
	
	$page_url = $this_url .'?aid='. $id .'&page=?page?';
	
	$count = 0;
	$page_size = 20;
	$list = $core->list_item(
		$select,
		array(
			'count' => &$count,
			'page' => &$page,
			'page_size' => $page_size
		)
	);
	
	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => $page_size,
		'url' => $page_url
	));
	
	include template($this_module, 'buy_list');
	
}