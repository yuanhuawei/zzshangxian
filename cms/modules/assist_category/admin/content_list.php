<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){

	$sid = isset($_GET['sid']) ? $_GET['sid'] : 0;
	
	$item = $this_system->load_module('item');
	$category = $this_system->load_module('category');
	$category->get_cache(true);
	$this_module->get_cache(true);
	$cms_cat=$category->categories;
	$ass_cat=$this_module->categories;
	
	$select = select();
	$select->from("{$this_module->list_table} AS l",'l.*');
	$select->left_join("{$item->main_table} AS i",'i.title,i.model,i.cid,i.views,i.comments,i.username,i.verified,i.timestamp','i.id=l.iid');

	if(!empty($sid)){
		$select->in('l.sid',$sid);
		$select->order('l.iid DESC');
	}
	
	$page_url = $this_url .'?page=?page?';
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page = max(1, $page);
	$count = 0;
	$page_size = 10;
	
	$content_list = $core->list_item($select,
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
	
	include template($this_module, 'content_list', 'admin');
}