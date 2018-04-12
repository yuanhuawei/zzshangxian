<?php
defined('PHP168_PATH') or die();

$this_controller->check_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	$id = $page = 0;
	foreach($URL_PARAMS as $k => $v){ 
		switch($v){
			case 'page':
				$page = isset($URL_PARAMS[$k +1]) ? intval($URL_PARAMS[$k +1]) : 0;
			break;
		}
	}

	$page = max(1, $page);

	//$page_url = p8_url($this_module, $this, 'list', false);
	$page_url = $this_url.'#-page-?page?#.html ';
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
	
	foreach($list as $key=>$row){
		//$list[$key]['url'] = p8_url($this_module, $row, 'post');
		$list[$key]['url'] = $this_router.'-post-id-'.$row['id'];
	}

	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => 20,
		'url' => $page_url
	));
	
	

	$SEO_KEYWORDS = $SEO_DESCRIPTION = '';
	$TITLE = $this_module->name.' - '.$core->CONFIG['site_name'];

	include template($this_module, 'list');
	
}else if(REQUEST_METHOD == 'POST'){
	exit;
	
}