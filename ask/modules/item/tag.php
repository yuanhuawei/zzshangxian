<?php
defined('PHP168_PATH') or die();

$list = $page_url_params = $itemtags = array();
$page_url = $tagname = $_tagname = $pages = '';
$page = 1;

foreach($URL_PARAMS as $k=>$v){
	switch($v){
		case 'tagname':
			$_tagname = !empty($URL_PARAMS[$k+1]) ? trim($URL_PARAMS[$k+1]) : '';
			$tagname = $_tagname = ($_tagname ? from_utf8(rawurldecode($_tagname)) : '');			
			break;
		case 'page':
			$page = isset($URL_PARAMS[$k+1]) ? intval($URL_PARAMS[$k+1]) : 1;
			$page = max(1, $page);
			break;
	}
}

//nav
$position = '<a href="' . $this_system->controller . '">' . $this_system->sitename . '</a>' . '&nbsp;&gt;&nbsp;<a href="' . $this_router . '-' . $ACTION . '">' . $P8LANG['ask_tags'] . '</a>';

//SEO
$sitename = $this_system->sitename . '-' . $this_system->sitetitle;
$keywords = $this_system->keywords;
$description = $this_system->description;

if(!empty($tagname)){

	$category = &$this_system->load_module('category');
	$category -> get_cache();
	
	$count = 0;
	$page_url_params['tagname'] = rawurlencode(to_utf8($_tagname));

	$select = select();
	$select -> from($this_module->table . ' AS I', 'I.*');	
	$select -> inner_join($this_module->table_itemtags . ' AS T', 'T.tagname', 'I.id=T.id');
	$select -> in('I.verify', 1);
	$select -> in('T.tagname', p8_addslashes($tagname));
	$select -> order('I.addtime DESC');

	$page_url_params['page'] = '?page?';
	$page_url = $this_module->name . '-' . $ACTION;
	$page_url .= page_url($page_url_params);

	$list = $core->list_item(
		$select,
		array(
			'page' => &$page,
			'count' => &$count,
			'page_size' => intval($this_system->CONFIG['perpage'])
		)
	);

	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => intval($this_system->CONFIG['perpage']),
		'url' => $page_url,
		'layout_size' => intval($this_system->CONFIG['layout_size']),
		'template' => $P8LANG['ask_page_template']
	));

	$position .= "&nbsp;&gt;&nbsp;$tagname";
	$sitename = $tagname.' - '.$sitename;

	include template($this_module, 'tag_items');
	
}
else{

	$tags_number =  !empty($this_system->CONFIG['tags_number']) ? intval($this_system->CONFIG['tags_number']) : 500;

	$itemtags = $this_controller->get_tags($tags_number);
	shuffle($itemtags);

	include template($this_module, 'tag');
}

