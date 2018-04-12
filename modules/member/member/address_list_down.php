<?php
/**
*address_list
**/
//$this_controller->check_admin_action($ACTION) or message('no_privilege');
if(REQUEST_METHOD == 'POST'){
	$id = isset($_POST['id']) ? $_POST['id'] : array();
	$role_gid = isset($_POST['role_gid']) ? intval($_POST['role_gid']) : 0;
	$role_id = isset($_POST['role_id']) ? intval($_POST['role_id']) : 0;
	$keyword = isset($_POST['keyword']) ? html_entities($_POST['keyword']) : '';
	$order = isset($_POST['order']) && $_POST['order'] == 'asc' ? 'ASC' : 'DESC';
	$type = isset($_POST['type']) ? $_POST['type'] : '';

	$select = select();
	$select->from($this_module->table, 'id, username, role_id, role_gid, name, email, phone, cell_phone, last_login_ip, last_login, status');
	
	if(empty($id)){
		
		if($role_id){
			$select->in('role_id', $role_id);
		}else if($role_gid){
			$select->in('role_gid', $role_gid);
		}
		
		if(!empty($_POST['is_admin'])){
			$select->in('is_admin', 1);
		}
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
					$select->like('pinyin', $keyword);
				}else{
					$select->like('username', $keyword);
				}
			break;
			case 'email':
				$select->like('mail', $keyword);
			break;	
		}
	}else{
		$select->in('id', $id);
	}

//echo $select->build_sql();exit;
	$count = 0;

	$list = $core->list_item($select);
	
	$status = array();
	foreach($this_module->status as $s => $l){
		$status[$s] = $P8LANG['member_status'][$l];
	}
	$core->get_cache('role_group');
	$core->get_cache('role');
	$data = $_list = array();
	foreach($list as $key=>$val){
		$_list['id'] = $val['id'];
		$_list['name'] = $val['name']? $val['name'] : $val['username'];
		$_list['role_gname'] = $core->role_groups[$val['role_gid']]['name'];
		$_list['role_name'] = $core->roles[$val['role_id']]['name'];
		$_list['phone'] = $val['phone'];
		$_list['cell_phone'] = $val['cell_phone'];
		$_list['email'] = $val['email'];
		$_list['status'] = $status[$val['status']];
		//$content .='"'.implode('","',$_list).'"'."\r\n";
		$data[] = $_list; 
	}
	
	 array_unshift($data,
		array(
			'id' => 'id',
			'name' => $P8LANG['name'],
            'role_gname' => $P8LANG['role_gname'],
            'role_name' => $P8LANG['role_name'],
			'phone' => $P8LANG['phone'],
            'cell_phone' => $P8LANG['cell_phone'],
            'email' => $P8LANG['email'],
            'status' => $P8LANG['status']
		),
		array(
			'id' => 'id',
			'name' => 'username',
            'role_gname' => 'role_gname',
            'role_name' => 'role_name',
			'phone' => 'phone',
            'cell_phone' => 'cell_phone',
            'email' => 'email',
            'status' => 'status'
		)
	); 
	include PHP168_PATH.'/inc/csv.class.php';
	$filename = 'address-list.csv';
	$csv = new P8_Csv();
	$csv->data = $data;
	$csv->file = 'php://output';
	header('Last-Modified: '. gmdate('D, d M Y H:i:s', P8_TIME) .' GMT');
	header('Pragma: no-cache');
	header('Content-type: csv');
	header('Content-Encoding: none');
	header('Content-Disposition: attachment; filename='. $filename);
	header('Content-type: csv');
	$csv->save();
	exit;
		

}
