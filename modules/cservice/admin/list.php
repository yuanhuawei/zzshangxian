<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');
GetGP(array('state','page','action','keyword','num','act'));
$act = $act? $act : 'search';
$state = isset($state)? $state:0;
$class[$state]='over';
$select = select();

$select->from($this_module->table, '*');
if(isset($state))$select->in('state',$state);
if(!empty($num))$select->in('num',trim($num));
if(!empty($keyword))$select->like('title',trim($keyword));
if(!empty($adminname))$select->in('adminnime',trim($adminname));

//$role = &$core->load_module('role');
//$role->get_cache();
if($act=='search'){
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page = max(1, $page);
}else{
	$page = 0;
}
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
$act=='search' && $pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => 20,
		'url' => $page_url
	));
$category = $this_module->CONFIG['cs_category'];

if($act=='search')
	include template($this_module, "list", 'admin');
else
	include template($this_module, "print_list", 'admin');	