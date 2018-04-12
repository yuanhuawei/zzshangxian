<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');


$select = select();

$select->from($this_module->table, '*');
$select ->order(' id desc');
//$role = &$core->load_module('role');
//$role->get_cache();


$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page = max(1, $page);

$page_url = $this_router .'-'. $ACTION .'?page=?page?';

$count = 0;
$list = $core->list_item(
	$select,
	array(
		'page' => &$page,
		'count' => &$count,
		'page_size' => 20
	)
);
if($this_module->CONFIG['htmlize'])require_once PHP168_PATH .'inc/html.func.php';
foreach($list as $k=>$v){
	$list[$k]['htmlurl'] = $this_module->CONFIG['htmlize']?p8_html_url($this_module, $v, 'view'):'';
	$list[$k]['url'] = p8_url($this_module, $v, 'view');
}

$pages = list_page(array(
	'count' => $count,
	'page' => $page,
	'page_size' => 20,
	'url' => $page_url
));
include template($this_module, 'list', 'admin');