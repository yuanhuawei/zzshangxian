<?php
/**
*address_list
**/
$this_controller->check_action($ACTION) or message('no_privilege');
$id = isset($_GET['id']) ? filter_int(explode(',', (string)$_GET['id'])) : array();
$role_gid = isset($_GET['role_gid']) ? intval($_GET['role_gid']) : 0;
$role_id = isset($_GET['role_id']) ? intval($_GET['role_id']) : 0;
$keyword = isset($_GET['keyword']) ? html_entities(from_utf8($_GET['keyword'])) : '';
$order = isset($_GET['order']) && $_GET['order'] == 'DESC' ? 'DESC' : 'ASC';
$type = isset($_GET['type']) ? $_GET['type'] : '';
$_keyword = isset($_GET['keyword']) ? html_entities($_GET['keyword']) : '';
$_type = isset($_GET['type']) ? $_GET['type'] : '';
if(P8_AJAX_REQUEST){
	
	$select = select();
	$select->from($this_module->table, 'id, username, number, role_id, role_gid, name, email, phone, cell_phone, last_login_ip, last_login, status');
	$select->in('status', 0);
	if(empty($id)){
		
		if($role_id){
			$select->in('role_id', $role_id);
		}else if($role_gid){
			$select->in('role_gid', $role_gid);
		}
		
		if(!empty($_GET['is_admin'])){
			$select->in('is_admin', 1);
		}
		if(!empty($keyword)){
		switch($type){
			case 'realname':
				if(preg_match('/[^a-zA-Z]/', $keyword)){
					$select->like('name', $keyword);
				}else{
					$select->like('pinyin', $keyword);
				}
			break;
			
			case 'phone':
				$select->like('phone', $keyword);
			break;
			
			case 'mobile':
				$select->like('cell_phone', $keyword);
			break;
			
			case 'name':
				if(preg_match('/[^a-zA-Z]/', $keyword)){
					$select->like('username', $keyword);
				}else{
					$select->like('pinyin', $keyword);
					
				}
			break;
			case 'email':
				$select->like('email', $keyword);
			break;	
		}
		}
	}else{
		$select->in('id', $id);
	}
	
	$select->order('display_order DESC,id '. $order);
	
	$page_url = 'javascript:request_item(?page?)';

	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page = max(1, $page);
	$page_size = 20;
//echo $select->build_sql();
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
$status_json = array();
foreach($this_module->status as $status => $lang){
	$status_json[$status] = $P8LANG['member_status'][$lang];
}
$core->get_cache('role_group');
$core->get_cache('role');

$role_group_json = p8_json($core->role_groups);
$role_json = p8_json($core->roles);
$status_json = p8_json($status_json);

$navgation = array(
array(
	'url'=>$this_url,'title'=>$P8LANG['address_list']
	)
);
$TITLE = $P8LANG['address_list'];
$baner = 'qiyetongxun';
include template($this_module,'address_list');
