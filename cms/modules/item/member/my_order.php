<?php
defined('PHP168_PATH') or die();



//$this_controller->check_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){

$page_url = $this_router .'-'. $ACTION .'?';

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page = max($page, 1);

$page_url .= '&page=?page?';
$select = select();

$select->from($this_module->order_table .' AS o', 'o.*');
$select->in('o.buyer_uid', $UID);
$select->order('o.timestamp DESC');

$count = 0;
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
//分页
	$pages = list_page(array(
			'count' => $count,
			'page' => $page,
			'page_size' => 20,
			'url' => $page_url
		));

	include template($this_module, 'my_order');
	
}else if(REQUEST_METHOD == 'POST'){
	
} 