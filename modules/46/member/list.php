<?php

/**
* 查看广告
**/

message('暂不开放');

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	$page = max(1, $page);
	
	$select = select();
	$select->from($this_module->table, '*');
	$select->in('buyable', 1);
	
	$page_url = $this_url .'?page=?page?';
	
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
	
	include template($this_module, 'list');
	
}