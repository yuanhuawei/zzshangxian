<?php
defined('PHP168_PATH') or die();

/**
* 会员管理
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');
if(REQUEST_METHOD == 'GET'){
$role_gid = isset($_GET['role_gid']) ? intval($_GET['role_gid']) : 0;
$role_id = isset($_GET['role_id']) ? intval($_GET['role_id']) : 0;
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$id = isset($_GET['id']) ? filter_int(explode(',', (string)$_GET['id'])) : array();
$order = isset($_GET['order']) && $_GET['order'] == 'ASC' ? 'ASC' : 'DESC';


if(P8_AJAX_REQUEST){
	
	$select = select();
	$select->from($this_module->table, 'id, username, role_id, role_gid, name, email, phone, cell_phone, last_login_ip, last_login,register_time, status, display_order');
	
	if(empty($id)){
		
		if($role_id){
			$select->in('role_id', $role_id);
		}else if($role_gid){
			$select->in('role_gid', $role_gid);
		}
		
		if(!empty($_GET['is_admin'])){
			$select->in('is_admin', 1);
		}
		
		if($keyword)
			$select->like('username', html_entities(from_utf8($keyword)));
		
	}else{
		$select->in('id', $id);
	}
	$select->order('display_order DESC,id '. $order);
	
	$page_url = 'javascript:request_item(?page?)';

	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page = max(1, $page);
	$page_size = 40;

	$count = 0;
	$list = $core->list_item(
		$select,
		array(
			'page' => &$page,
			'count' => &$count,
			'page_size' => $page_size,
			'ms' => 'master'
		)
	);
	
	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => $page_size,
		'url' => $page_url
	));
	
	$json = p8_json(array(
		'list' => $list,
		'pages' => $pages
	));
	//echo $select->build_sql();
	exit($json);
}

$allow_update = $this_controller->check_admin_action('update');
$allow_delete = $this_controller->check_admin_action('delete');
$allow_send = $this_controller->check_admin_action('batch_send');
$allow_credit = $this_controller->check_admin_action('credit');
$allow_set_acl = $this_controller->check_admin_action('credit');

$status_json = array();
foreach($this_module->status as $status => $lang){
	$status_json[$status] = $P8LANG['member_status'][$lang];
}

$core->get_cache('role_group');
$core->get_cache('role');

$role_group_json = p8_json($core->role_groups);
$role_json = p8_json($core->roles);
$status_json = p8_json($status_json);

include template($this_module, 'list', 'admin');
}else if(REQUEST_METHOD == 'POST'){
	
	$display_order = isset($_POST['_display_order']) ? array_map('intval', (array)$_POST['_display_order']) : array();
		
		foreach($display_order as $id => $order){
			$id = intval($id);
			
			$DB_master->update(
				$this_module->table,
				array('display_order' => $order),
				"id = '$id'"
			);
		}
		
		$display_order && $this_module->cache();
		message('done');
}