<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page = max(1, $page);
	
	$iid = isset($_GET['iid'])? intval($_GET['iid']) : 0;

	$page_url = $this_router .'-'. $ACTION .'?page=?page?';
	$count = 0;
	$select = select();
	$select -> from($this_module->data_table.' AS d','d.*');
	$select -> left_join($this_module->table.' AS i','i.title as item_title', ' i.id=d.iid');
	if($iid)$select->in('d.iid',$iid);
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
	
	include template($this_module, 'list', 'admin');
	//print_r($list);
}else if(REQUEST_METHOD == 'POST'){
	
}