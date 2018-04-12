<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action('buy') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$bid = isset($_GET['bid']) ? $_GET['bid'] : 0;
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page = max($page, 1);
	
	$data = $DB_master->fetch_one("SELECT * FROM $this_module->buy_table AS b
		INNER JOIN $this_module->table AS a ON a.id = b.aid WHERE b.id = '$bid'");
	$data or message('no_such_item');
	
	$aid = $data['aid'];
	
	$select = select();
	$select->from($this_module->click_log_table .' AS l', 'l.*');
	$select->in('l.bid', $bid);

	$page_url = $this_url .'?bid='. $bid .'&page=?page?';
	$select->order('l.timestamp DESC');
	
	$page_size = 20;
	$count = 0;
	$list = $core->list_item(
		$select,
		array(
			'page' => &$page,
			'count' => &$count,
			'page_size' => $page_size
		)
	);
	
	//echo $select->build_sql();
	
	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => $page_size,
		'url' => $page_url
	));
	
	include template($this_module, 'click', 'admin');

}