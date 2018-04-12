<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');
GetGP(array('status','page','action','keyword','number','act','solve_name','source'));
$act = $act? $act : 'search';
$status = isset($status)? $status:0;
$class[$status]='over';


//$role = &$core->load_module('role');
//$role->get_cache();
if($act=='search'){
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page = max(1, $page);
}else{
	$page = 0;
}

$select = select();

$select->from($this_module->table, '*');
if(isset($status))$select->in('status',$status);
if(!empty($number))$select->in('number',trim($number));
if(!empty($keyword))$select->like('title',trim($keyword));
if(!empty($solve_name))$select->in('solve_name',trim($solve_name));
if(!empty($source))$select->in('solve_name',intval($source)-1);
$count = 0;
//echo $select->build_sql();
$page_url = $this_router .'-'. $ACTION .'?status='.$status.'&page=?page?';

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
$cates = $this_module->get_category();
if($act=='search')
	include template($this_module, "list", 'admin');
else
	include template($this_module, "print_list", 'admin');	