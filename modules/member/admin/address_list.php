<?php
defined('PHP168_PATH') or die();

/**
* йтоб
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

$role_gid = isset($_GET['role_gid']) ? intval($_GET['role_gid']) : 0;
$role_id = isset($_GET['role_id']) ? intval($_GET['role_id']) : 0;
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$id = isset($_GET['id']) ? filter_int(explode(',', (string)$_GET['id'])) : array();
$order = isset($_GET['order']) && $_GET['order'] == 'asc' ? 'ASC' : 'DESC';
$name = isset($_GET['name']) ? html_entities(from_utf8($_GET['name'])) : '';
$phone = isset($_GET['phone']) ? html_entities($_GET['phone']) : '';
$cell_phone = isset($_GET['cell_phone']) ? html_entities($_GET['cell_phone']) : '';


if(P8_AJAX_REQUEST){
	
	$select = select();
	$select->from($this_module->table, 'id, username, role_id, role_gid, name, email, phone, cell_phone, last_login_ip, last_login, status');
	
	if(empty($id)){
		
		if($role_id){
			$select->in('role_id', $role_id);
		}else if($role_gid){
			$select->in('role_gid', $role_gid);
		}
		
		if(!empty($_GET['is_admin'])){
			$select->in('is_admin', 1);
		}
		
		if($name){
			if(preg_match('/[^a-zA-Z]/', $name)){
				$select->like('name', $name);
			}else{
				$select->like('pinyin', $name);
			}
		}
		
		if($phone){
			$select->like('phone', $phone);
		}
		
		if($cell_phone){
			$select->like('cell_phone', $cell_phone);
		}
		
		if($keyword)
			$select->like('username', html_entities(from_utf8($keyword)));
		
	}else{
		$select->in('id', $id);
	}
	
	$select->order('id '. $order);
	
	$page_url = 'javascript:request_item(?page?)';

	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page = max(1, $page);
	$page_size = 20;

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

$status_json = array();
foreach($this_module->status as $status => $lang){
	$status_json[$status] = $P8LANG['member_status'][$lang];
}

$core->get_cache('role_group');
$core->get_cache('role');

$role_group_json = p8_json($core->role_groups);
$role_json = p8_json($core->roles);
$status_json = p8_json($status_json);

include template($this_module, 'address_list', 'admin');