<?php
/**
*ÏêÏ¸
**/
defined('PHP168_PATH') or die();
$this_controller->check_action($ACTION) or message('no_privilege');
if(REQUEST_METHOD == 'GET'){
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page = max(1, $page);
	$id = isset($_GET['id'])? intval($_GET['id']) : '';
	$role_gid = isset($_GET['role_gid']) ? intval($_GET['role_gid']) : 0;
	$role_id = isset($_GET['role_id']) ? intval($_GET['role_id']) : 0;
	$keyword = isset($_GET['keyword']) ? html_entities(from_utf8($_GET['keyword'])) : '';
	$receive = isset($_GET['receive']) ? html_entities($_GET['receive']) : '';
	$status = isset($_GET['status']) ? html_entities($_GET['status']) : '';
	
if(P8_AJAX_REQUEST){	
	$select = select();
	$select->from($this_module->sign_in_table .' AS i', 'i.*');
	$select->inner_join($core->member_table .' AS m', 'm.username, m.name, m.role_id, m.role_gid', 'i.uid = m.id');
	$select->in('i.nid',$id);
	
	if($role_id){
		$select->in('m.role_id', $role_id);
	}else if($role_gid){
		$select->in('m.role_gid', $role_gid);
	}
	if($receive !=''){
		$select->in('i.receive',$receive);
	}
	if($status!=''){
		$select->in('i.status', $status);
	}
	if($keyword){
		if(preg_match('/[^a-zA-Z]/', $keyword)){
			$select->like('m.name', $keyword);
		}else{
			$select->like('m.pinyin', $keyword);
		}
	}
	
	$page_url = $this_url .'?';
	$page_url = 'javascript:request_item(?page?)';
	$page_size = 20;
	$count = 0;
	//echo $select->build_sql();
	$list = $core->list_item(
		$select,
		array(
			'count' => &$count,
			'page' => &$page,
			'page_size' => $page_size
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
$data = $core->DB_master->fetch_one("SELECT title, content FROM $this_module->table WHERE id = '$id'");
	$core->get_cache('role_group');
	$core->get_cache('role');
	$role_group_json = p8_json($core->role_groups);
	$role_json = p8_json($core->roles);
	$status_json = p8_json($this_module->CONFIG['status']);
	
	include template($this_module,'show');

}else if(REQUEST_METHOD=='POST'){
	$action = isset($_POST['action']) ? $_POST['action'] : '';
	
	switch($action){
		case 'sign':
			$id = isset($_POST['id']) ? intval($_POST['id']) : '';
			if(empty($id))exit('[]');
			$uid = isset($_POST['uid']) ? intval($_POST['uid']) : '';
			$hash = isset($_POST['hash']) ? $_POST['hash'] : '';
			$status = isset($_POST['status']) ? intval($_POST['status']) : '';
			$comment = isset($_POST['comment'])? from_utf8(p8_html_filter($_POST['comment'])) : '';
			$data=array(
				'id' => $id,
				'uid' => $uid,
				'status' => $status,
				'hash' => $hash,
				'comment' => $comment
			);
			$this_module->sign_in(&$data) or exit('[]');
			$returndata = $this_module->check_one_sign($id,$uid);
			$returndata['timestamp'] = date('Y-m-d h:i:s',$returndata['timestamp']);
			exit(p8_json($returndata));
		break;
		case 'show':
			$id = isset($_POST['id']) ? intval($_POST['id']) : '';
			$uid = isset($_POST['uid']) ? intval($_POST['uid']) : '';
			if(empty($id))exit('[]');
			$data = $core->DB_master->fetch_one("SELECT n.id, n.title, n.content, i.uid, i.comment, i.status, i.hash FROM {$this_module->table} as n INNER JOIN {$this_module->sign_in_table} as i ON n.id=i.nid WHERE n.id = '$id' AND i.uid=$uid");
			exit(p8_json($data));
		break;
		case 'delete':
			$id = isset($_POST['id']) ? intval($_POST['id']) : '';
			$uid = isset($_POST['uid']) ? $_POST['uid'] : array();
			$uid or exit('[]');
			$this_module->delete_sign(array(
				'where' => "uid IN (". implode(',', $uid) .") AND nid = '$id'",
				'id' => $id
			));
			
			exit(p8_json($uid));
		break;
	}
}