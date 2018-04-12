<?php
defined('PHP168_PATH') or die();
$is_admin=$this_controller->check_action('admin_replay');

GetGP(array('id','act'));
$act = $act? $act : 'view';
if(empty($id))message('{}');
$select = select();

$select->from($this_module->table, '*');
$select->in('id',$id);

$askdata = $core->select($select,array('single' => true));
$mind=$askdata['uid']==$UID?1:0;

if($act=='print'){
	$page = 0;
}else{
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page = max(1, $page);
}
$page_url = $this_router .'-'. $ACTION .'?page=?page?&id=$id';
$member = $this_system->load_module('member');
$roledata = $CACHE->read('core/modules', 'role', 'roles', 'serialize');
$roles = $roledata['roles'];
$count = 0;
$select2=select();
$select2->from($this_module->table_reply.' as i', 'i.*');
$select2->inner_join($member->table.' as m', 'm.role_id','i.uid = m.id');
$select2->in('i.askid',$id);


$listdb = $core->list_item(
	$select2,
	array(
	'page' => &$page,
	'count' => &$count,
	'page_size' => 20
));

$act=='view' && $pages = list_page(array(
	'count' => $count,
	'page' => $page,
	'page_size' => 20,
	'url' => $page_url
));
$categories = $this_module->CONFIG['cs_category'];
$listdb && $listdb=$this_controller->format_data(&$listdb);
$repilit=($is_admin && !$mind)?1:0;
if($act=='view')
	include template($this_module, "view");
else
	include template($this_module, "print_view");	
?>