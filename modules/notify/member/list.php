<?php
/***
*ап╠М
**/
defined('PHP168_PATH') or die();
//$this_controller->check_action($ACTION) or message('no_privilege');
if(REQUEST_METHOD == 'GET'){
	
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page = max(1, $page);
	$page_size = 20;
	$count = 0;
	$my_nid = '';
	$select = select();
	$select->from($this_module->table .' AS i', 'i.id, i.uid, i.title, i.send_count, i.sign_in_count, i.timestamp');
	$my_nid = $this_module->get_my_notify($UID,($page-1)*$page_size,$page_size);
	if($IS_FOUNDER){
	
	}else
	if($this_controller->check_action('edit')){
		$select->in('i.id',$my_nid);
		$select->where_or();
		$select->in('i.uid',$UID);
	}else{
		$select->in('i.id',$my_nid);
	}
	
	$select->order('id DESC');
	
	$page_url = $this_url .'?page=?page?';
	//echo $select->build_sql();
	$list = $core->list_item(
		$select,
		array(
			'count' => &$count,
			'page' => &$page,
			'page_size' => $page_size
		)
	);
	
	foreach($list as $key => $rs){
		if($rs['send_count']){
			$mysign=$this_module->check_one_sign($rs['id'],$UID);
			$list[$key]['receive']=empty($mysign['receive'])? 0 : 1;
			$list[$key]['status']=empty($mysign['status'])? 0 : $mysign['status'];
			$list[$key]['hash']=$mysign['hash'];
		}
		$list[$key]['no_receive'] = max(0,$rs['send_count'] - $rs['sign_in_count']);
		$list[$key]['status_count'] = $this_module->status_count($rs['id']);


	}
	//print_r($list);
	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => $page_size,
		'url' => $page_url
	));
	
	$view_link = $this_controller->check_action('edit');
	$resend_link = $this_controller->check_action('resend');
	$delete_link = $this_controller->check_action('edit');
	include template($this_module, 'list');

}else if(REQUEST_METHOD == 'POST'){
	
	$action = isset($_POST['action']) ? $_POST['action'] : '';
	
	switch($action){
	case 'sign':
		//$this_controller->check_action('show&sign') or exit(p8_json('no_privilege'));
		$id = isset($_POST['id']) ? intval($_POST['id']) : '';
		if(empty($id))exit('[]');
		$hash = isset($_POST['hash']) ? $_POST['hash'] : '';
		$status = isset($_POST['status']) ? intval($_POST['status']) : '';
		$comment = isset($_POST['comment'])? from_utf8(p8_html_filter($_POST['comment'])) : '';
		$data=array(
			'id' => $id,
			'uid' => $UID,
			'status' => $status,
			'hash' => $hash,
			'comment' => $comment
		);
		$this_module->sign_in(&$data) or exit('[]');
		$returndata = $this_module->check_notify($id);
		$returndata['id']=$id;
		$returndata['status']=$status;
		exit(p8_json($returndata));
	break;
	case 'show':
		//$this_controller->check_action('show&sign') or exit(p8_json('no_privilege'));
		$id = isset($_POST['id']) ? intval($_POST['id']) : '';
		if(empty($id))exit('[]');
		$data = $core->DB_master->fetch_one("SELECT n.id, n.title, n.content, i.comment, i.status, i.hash FROM {$this_module->table} as n INNER JOIN {$this_module->sign_in_table} as i ON n.id=i.nid WHERE n.id = '$id' AND i.uid=$UID");

		if(empty($data) && $this_controller->check_action('edit')){
			$data = $this_module->view($id);
		}
		empty($data) && exit(p8_json('no_such_item'));
		

		$core->DB_slave->update($this_module->sign_in_table,array('receive' => 1),"nid = '$id' AND uid = '$UID'");
		exit(p8_json($data));
	break;
	case 'delete':
		$this_controller->check_action('edit') or exit(p8_json('no_privilege'));
		$id = isset($_POST['id']) ? filter_int($_POST['id']) : array();
		$id or exit('[]');
		
		$this_module->delete(array(
			'where' => 'id IN ('. implode(',', $id) .')'
		));
		
		exit(p8_json($id));
	break;

	
	}
	
}