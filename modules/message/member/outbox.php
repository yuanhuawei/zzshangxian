<?php
defined('PHP168_PATH') or die();

/**
* ·¢¼þÏä
**/

if(REQUEST_METHOD == 'GET'){
	
	$type = isset($_GET['type']) && $_GET['type'] == 'draft' ? 'draft' : 'out';
	
	$page_url = $this_url .'?page=?page?';
	$select = select();
	$select->from($this_module->table .' AS m', 'm.id, m.username, m.title, m.new, m.timestamp');
	$select->in('m.sender_uid', $UID);
	$select->in('m.type', $type);
	
	$select->order('m.timestamp DESC');
	
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page = max(1, $page);
	$count = 0;
	$page_size = 10;
	
	$list = $core->list_item(
		$select,
		array(
			'page' => &$page,
			'count' => &$count,
			'page_size' => $page_size
		)
	);
	
	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => $page_size,
		'url' => $page_url
	));
	if(P8_AJAX_REQUEST){
		$page_url = $this_url .'?';
		$page_url = 'javascript:IntraMail.request_item(?page?)';
		$json = p8_json(
			array('list'=>$list, 
			'pages'=>list_page(array(
				'count' => $count,
				'page' => $page,
				'page_size' => $page_size,
				'url' => $page_url
			))
			
			));
		exit($json);
	}
	include template($this_module, 'outbox');
	
}
//include template($this_module, 'member/outbox');