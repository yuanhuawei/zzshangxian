<?php
defined('PHP168_PATH') or die();

/**
* Í¶Æ±ÁÐ±í
**/

if(REQUEST_METHOD == 'GET'){
	
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page = max($page, 1);
	
	$page_url = $this_url .'?page=?page?';
	
	$select = select();
	$select->from($this_module->table, '*');
	$select->order('id DESC');
	
	$count = 0;
	$page_size = 20;
	$list = $core->list_item(array(
		$select,
		array(
			'count' => &$count,
			'page' => &$page,
			'page_size' => $page_size,
		)
	));
	
	$pages = list_page(array(
		'count' => &$count,
		'page' => $page,
		'page_size' => $page_size,
		'url' => $page_url,
	));
	
	include template($this_module, 'list');
}