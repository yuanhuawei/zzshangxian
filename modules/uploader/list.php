<?php
defined('PHP168_PATH') or die();

//$this_controller->check_action($ACTION) or message('no_privilege');

header('Pragma: no-cache');
header('Cache-Control: no-cache, must-revalidate');

$system = isset($_GET['system']) ? p8_addslashes($_GET['system']) : 'core';
$module = isset($_GET['module']) ? p8_addslashes($_GET['module']) : '';
$keyword = isset($_GET['keyword']) ? p8_addslashes(trim($_GET['keyword'])) : '';

if($system != 'core' && !get_system($system)) message('no_such_system');

if($module && !get_module($system, $module)){
	message('no_such_module');
}

if($system != 'core'){
	$sys_info = get_system($system);
	$table = $sys_info['table_prefix'] .'attachment';
}else{
	$table = $this_module->table;
}

$select = select();
$select->from($table, '*');

//if(!$IS_FOUNDER)
if($UID){
	$select->in('uid', $UID);
}else{
	$select->in('uid', 0);
	$select->in('ip', P8_IP);
}

if($module)
	$select->in('module', $module);



$select->order('id DESC');

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page = max(1, $page);

$page_url = $this_url .'?system='. $system .'&module='. $module;

if($keyword){
	$select->like('filename', $keyword);
	$page_url .= '&keyword='.$keyword;
}

$page_url .= '&page=?page?';

$page_size = 10;
//echo $select->build_sql();
$count = 0;
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

$remote_attachment_urls = p8_json($core->CONFIG['attachment']['remote']['server']);

include template($this_module, 'list', 'default');
exit;