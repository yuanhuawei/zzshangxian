<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page = max(1, $page);
	
	$select = select();
	$select->from($this_module->table .' AS i', 'i.*');
	$select->order('id DESC');
	
	$page_url = $this_url .'?page=?page?';
	
	if($keyword){
		$select->like('i.name', html_entities($keyword));
		$page_url .= '&keyword='. urlencode($keyword);
	}
	
	$page_size = 20;
	$count = 0;
	
	$list = $core->list_item(
		$select,
		array(
			'count' => &$count,
			'page' => &$page,
			'page_size' => $page_size
		)
	);
	
	foreach($list as $k => $v){
		$file = $this_module->js_file($v['id']);
		$list[$k]['invoke'] = html_entities('<script type="text/javascript" src="'. $this_module->url .'/js/'. $file .'"></script>|'.
			'<script type="text/javascript" src="{$core.modules[\''. $MODULE .'\'][\'url\']}/js/'. $file .'"></script>|'.
			$P8LANG['vote_invoke_note']
		);
	}
	
	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => $page_size,
		'url' => $page_url
	));
	
	include template($this_module, 'list', 'admin');
	
}