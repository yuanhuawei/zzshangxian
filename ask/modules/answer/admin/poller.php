<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action('poller') or message('no_privilege');

load_language($this_system, 'admin');

//载入问题模块
$item = &$this_system->load_module('item');

$header_url = '';
$url = $this_router . '-' . $ACTION . '?page=?page?';
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page = max(1, $page);

$select = select();
$select->from($this_module->table_poller . ' AS A', 'A.*');
$select->inner_join($this_module->table . ' AS B','B.tid,B.verify','B.id=A.aid');
$select->inner_join($this_module->table_data . ' AS C', 'C.content AS answer_content', 'A.aid=C.id');
$select->order('A.id DESC');

$count = 0;
$virtual_list = $list = $core->list_item(
	$select,
	array(
		'page' => &$page,
		'count' => &$count,
		'page_size' => 15
	)
);
foreach($virtual_list as $k=>$v){
	$virtual_list[$k]['id'] = $virtual_list[$k]['tid'];
	$list[$k]['item_url'] = p8_url($item, $virtual_list[$k], 'view');
	unset($list[$k]['answer_content']);
	$list[$k]['answer_content']=p8_cutstr($v['answer_content'],30);
}

$pages = list_page(array(
	'count' => $count,
	'page' => $page,
	'page_size' => 15,
	'url' => $url
));

include template($this_module, 'poller', 'admin');