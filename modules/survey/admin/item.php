<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page = max(1, $page);

	$page_url = $this_router .'-'. $ACTION .'?page=?page?';
	$count = 0;
	$select = select();
	$select -> from($this_module->table,'*');
	$select -> order('id DESC');
	$list = $core->list_item(
		$select,
		array(
			'page' => &$page,
			'count' => &$count,
			'page_size' => 20
		)
	);

	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => 20,
		'url' => $page_url
	));
	
	include template($this_module, 'item', 'admin');
}else if(REQUEST_METHOD == 'POST'){
	$ids = $_POST['id'];
	
	$ids = implode($ids);
	
	$this_module->cache_result($ids);
	
	exit('{"error":0}');
}