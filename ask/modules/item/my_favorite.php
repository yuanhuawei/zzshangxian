<?php
defined('PHP168_PATH') or die();

//$this_controller->check_action($ACTION) or message('no_privilege');

if(empty($UID)){
	message('not_login');
}

$filter = $page_url = '';
$list = array();
$page = 1;
$count = 0;

//�������ģ��
$category = &$this_system->load_module('category');
$category -> get_cache();

foreach($URL_PARAMS as $k=>$v){
	switch($v){
		case 'page':
			$page = isset($URL_PARAMS[$k+1]) ? intval($URL_PARAMS[$k+1]) : 1;
			$page = max(1, $page);
			break;
	}
}

$select = select();
$select->from($this_module->table_favorites . ' AS F', 'F.*,F.id AS fav_id');
$select->inner_join($this_module->table . ' AS I', 'I.id,I.title,I.uid AS puid,I.username AS pusername,I.cid,I.replies,I.addtime AS paddtime,I.status', 'I.id=f.tid');
$select->in('f.uid', $UID);

$list = $core->list_item(
	$select,
	array(
		'page' => &$page,
		'count' => &$count,
		'page_size' => intval($this_system->CONFIG['perpage'])
	)
);

foreach($list as $k=>$v){
	$list[$k]['url'] = p8_url($this_module, $list[$k], 'view');
}

$pages = list_page(array(
	'count' => $count,
	'page' => $page, 
	'page_size' => intval($this_system->CONFIG['perpage']), 
	'url' => $this_router.'-'.$ACTION.'-page-?page?-filter-'.$filter,
	'layout_size' => intval($this_system->CONFIG['layout_size']), 
	'template' => $P8LANG['ask_page_template']
));


include template($this_module, 'my_favorite');