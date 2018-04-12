<?php
defined('PHP168_PATH') or die();

/**
* ³äÖµ¼ÇÂ¼
**/

if(REQUEST_METHOD == 'GET'){
	
	$select = select();
	$select->from($this_module->TABLE_ .'recharge');
	$select->in('uid', $UID);
	$select->order('timestamp DESC');
	
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page = max(1, $page);
	
	$page_size = 20;
	
	$list = $core->list_item(
		$select,
		array(
			'page' => &$page,
			'count' => &$count,
			'page_size' => $page_size
		)
	);
	
	$page_url = $this_url .'?page=?page?';
	
	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => $page_size,
		'url' => $page_url
	));
	
	include template($this_module, 'recharge_log');
	
}