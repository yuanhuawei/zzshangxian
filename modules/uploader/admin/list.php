<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

$system = isset($_GET['system']) ? $_GET['system'] : 'core';
$module = isset($_GET['module']) ? $_GET['module'] : '';
$fetch = true;
$pages = '';


$systems = $core->systems;
$modules = get_modules($system);

$select = select();
if($system == 'core'){
	$table = $this_module->table;
}else{
	$sys_info = get_system($system);
	$table = $sys_info['table_prefix'] .'attachment';
}
$select->from($table .' AS a', 'a.*');
$select->inner_join($core->member_table .' AS m', 'm.username', 'm.id = a.uid');
$select->order('a.id DESC');

if($module){
	$select->in('module', $module);
	$select->order('a.timestamp DESC');
}

$a_config = $core->CONFIG['attachment'];

//echo $select->build_sql();
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page = max(1, $page);

$page_url = $this_url .'?system='. $system .'&module='. $module .'&page=?page?';

$count = 0;
$list = $core->list_item(
	$select,
	array(
		'page' => &$page,
		'count' => &$count,
		'page_size' => 20
	)
);

$pages = list_page(array(
	'count' => $count,
	'page' => $page,
	'page_size' => 20,
	'url' => $page_url
));

include template($this_module, 'list', 'admin');
