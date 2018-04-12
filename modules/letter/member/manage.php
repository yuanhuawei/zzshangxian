<?php
defined('PHP168_PATH') or die();
$this_controller->check_action('manager') or message('no_privilege');
GetGP(array('status','page','action','keyword','type','department','act'));
$act = $act? $act : 'search';

//$this_controller->check_manage($department,$type) or	message('no_privilege');
	
$select = select();
$select->from($this_module->table, 'id,department,type,number,username,create_time,title,status');
$state = isset($status)? $status:0;
$sta[$state]=" class='over'";
if($state==1)
$select->in('status',3);
else
$select->in('status',3,true);
if(!empty($department))$select->in('department',trim($department));
if(!empty($type))$select->in('type',trim($type));
if(!empty($keyword))$select->like('title',trim($keyword));
$select->order('create_time DESC');

if($act=='search'){
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page = max(1, $page);
}else{
	$page = 0;
}

$page_url = $this_router .'-'. $ACTION .'?page=?page?';
//echo $select->build_sql();
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
	
$cates = $this_module->get_category();
$id_type = $this_module->id_type();
if($act=='search')
	include template($this_module, "manage");
else
	include template($this_module, "print_list");	

?>