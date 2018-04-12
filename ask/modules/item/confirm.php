<?php
defined('PHP168_PATH') or die();

$page_url = $this_router . '-' . $ACTION;

$keyword = isset($_GET['keyword']) ? xss_clear(rawurldecode($_GET['keyword'])) : '';

if(empty($keyword)){
	message('ask_error', HTTP_REFERER, 3);
}

$select = select();
$select->from($this_module->table . ' AS T', 'T.*');
$select->in('T.verify', 1);
$select->in('T.status', 3);
$select->in('T.closed', 0);
$select->like('T.title', p8_addslashes($keyword));
$select->order('T.solvetime DESC');

$count = 0;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page = max(1, $page);
$list = $core->list_item(
	$select,
	array(
		'page' => &$page,
		'count' => &$count,
		'page_size' => intval($this_system->CONFIG['confirm_perpage'])
	)
);

$page_url .= '?keyword=' . rawurlencode($keyword) . '&page=' . $page;
$pages = list_page(array(
	'count' => $count, 
	'page' => $page,
	'page_size' => intval($this_system->CONFIG['confirm_perpage']), 
	'url' => $page_url, 
	'layout_size' => intval($this_system->CONFIG['confirm_layout_size']), 
	'template' => $P8LANG['ask_common_page_template']
));

$position = $this_system->position . '&nbsp;&gt;&nbsp;' . $P8LANG['ask_question'];

//SEO
$sitename = $keyword . ' - ' . $this_system->sitename . '-' . $this_system->sitetitle;
$meta_keywords = $keyword . ',' . $this_system->meta_keywords;
$meta_description = $keyword . ',' . $this_system->meta_description;

include template($this_module, 'confirm');
