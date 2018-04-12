<?php
defined('PHP168_PATH') or die();

/**
* ¹ÜÀí¶©µ¥
**/

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page = max($page, 1);

$page_url = $this_url .'?page=?page?';
$NO = isset($_GET['NO']) ? $this_controller->valid_NO($_GET['NO']) : '';
$status = isset($_GET['status']) ? intval($_GET['status']) : null;

$select = select();
$select->from($this_module->order_table .' AS o', 'o.*');

if(strlen($NO)){
	$select->like('NO', $NO, 'left');
	$page_url .= '&NO='. urlencode($NO);
}else{
	if($status !== null){
		$select->in('status', $status);
	}
	
	
}

$select->order('id DESC');

$count = 0;
$page_size = 20;
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
	'page_size' => $page_size,
	'url' => $page_url
));

include template($this_module, 'list_order', 'admin');