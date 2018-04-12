<?php
defined('PHP168_PATH') or die();
$is_admin=$this_controller->check_action('admin_replay');
GetGP(array('state','page','action','keyword','num','catid','act'));
$act = $act? $act : 'search';
$select = select();
if(!$is_admin){
$select->in('uid',$UID);
}
$select->from($this_module->table, 'id,num,state,title,timestamp,solvetime,username,category');
$state = isset($state)? $state:0;
$sta[$state]=" class='over'";
if($state==1)
$select->in('state',2);
else
$select->in('state',2,true);
if(!empty($catid))$select->in('category',trim($catid));
if(!empty($num))$select->in('num',trim($num));
if(!empty($keyword))$select->like('title',trim($keyword));
if(!empty($adminname))$select->in('adminnime',trim($adminname));
$select->order('timestamp DESC');
//$role = &$core->load_module('role');
//$role->get_cache();
//echo $select->build_sql();

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
	include template($this_module, "list");
else
	include template($this_module, "print_list");	

?>