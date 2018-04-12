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
		case 'filter':
			$filter = isset($URL_PARAMS[$k+1]) ? $URL_PARAMS[$k+1] : '';
			break;
		case 'page':
			$page = isset($URL_PARAMS[$k+1]) ? intval($URL_PARAMS[$k+1]) : 1;
			$page = max(1, $page);
			break;
	}
}

$select = select();
$select->from($this_module->table_answer . ' AS A', 'A.*,A.id AS aid');
$select->inner_join($this_module->table . ' AS I', 'I.id,I.title,I.uid AS puid,I.username AS pusername,I.cid,I.replies,I.addtime,I.status', 'I.id=A.tid');
$select->in('A.uid', $UID);
//�����ɵĻش� 
if($filter == 'verify'){
	$select -> in('A.verify', 1);
	$select->order('a.id DESC');
}
//����ش�
elseif($filter == 'best'){
	$select->in('A.bestanswer', 1);
	$select->order('A.addtime DESC');
}
//δ���
elseif($filter == 'not_verify'){
	$select->in('A.verify', 0);
	$select->order('A.id DESC');
}
else{
	$select->order('A.id DESC');
}

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

include template($this_module, 'my_answered');