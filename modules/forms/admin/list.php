<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	$mid = isset($_GET['mid'])? intval($_GET['mid']) : '';
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page = max(1, $page);
	$page_url = $this_router .'-'. $ACTION .'?page=?page?';
	$count = 0;
	//我管理的表单
	$my_forms_manage = $this_controller->get_acl('my_forms_manage');
	$mids = $my_forms_manage? array_keys($my_forms_manage) : array();
	if($mid && !$this_controller->check_model_action('manage', $mid))message('no_model_privilege');
	
	if(!$mid){
		$select = select();
		$select -> from($this_module->model_table,'*');
		$select -> order('display_order DESC, id DESC');
		if(!$IS_FOUNDER)$select -> in('id',$mids);
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
		include template($this_module, 'select_model', 'admin');
		exit;
	}
	$this_module->set_model($mid) or message('no_such_model');
	//搜索开始
	
	$page_url .= "&mid=$mid";
	
	
	$select = select();
	$select -> from("$this_module->table as i",'i.*');
	$select -> left_join("$this_module->data_table as d",'d.*','i.id=d.id');
	$select -> in('i.mid',$mid);
	//搜索条件
	$mindate = isset($_GET['mindate']) ? $_GET['mindate'] : '';
	if($mindate){
		$page_url .= "&mindate=$mindate";
		$select -> range('i.timestamp',strtotime($mindate));
	}
	$maxdate = isset($_GET['maxdate']) ? $_GET['maxdate'] : '';
	if($maxdate){
		$page_url .= "&maxdate=$maxdate";
		$select -> range('i.timestamp',null,strtotime($maxdate));
	}
	$username = isset($_GET['username']) ? p8_html_filter($_GET['username']) : '';
	if($username){
		$page_url .= "&username=$username";
		$select -> like('i.username',$username);
	}
	$selectstatus = isset($_GET['selectstatus']) ? $_GET['selectstatus'] : '';

	if($selectstatus!=''){
		$selectstatus = intval($selectstatus);
		$page_url .= "&selectstatus=$selectstatus";
		$select -> in('i.status',$selectstatus);
	}
	//自定义字段过滤
	$F = isset($_GET['field#']) ? $_GET['field#'] : array();

	foreach($this_model['filterable_fields'] as $field=>$field_data){
		if(!empty($F[$field])){
			if($field_data['widget']=='text'){
				$data[$field] = $F[$field];
				$page_url .= "&field%23[$field]=$F[$field]";
				$select -> like("d.$field",$F[$field]);
			}elseif($field_data['widget']=='radio' || $field_data['widget']=='select' || $field_data['widget']=='city'){
				$data[$field] = $F[$field];
				$page_url .= "&field%23[$field]=$F[$field]";
				$select -> in("d.$field",$F[$field]);
			}elseif($field_data['widget']=='checkbox' || $field_data['widget']=='multi_select'){
				if(!empty($F[$field])){
					foreach($F[$field] as $v){
						if(array_key_exists($v,$field_data['data'])){
							$data[$field][] = $v;
							$page_url .= "&field%23[$field][]=$v";
							$select -> like("d.$field",$v);
						}	
					}
				}
			}elseif($field_data['widget']=='linkage'){
				foreach($F[$field] as $k=>$vl){
						if($vl)
						$data[$field] = $vl;
				}
				if($data[$field]){
					$page_url .= "&field#[$field]=$F[$field]";
					$select -> like("d.$field",$data[$field],'left');
				}
			}
		}
	}
	
	$select -> order('i.display_order DESC,i.id DESC');
//echo $select->build_sql();	
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
	foreach($list as $key=>$detail){
		$this_module->format_data($list[$key]);
		$this_module->format_view($list[$key]);
		$list[$key]['url'] = p8_url($this_module,$detail,'view');
	}
	//$status = $this_model['CONFIG']['status'];
	$status = $this_module->CONFIG['status'];
	$status_json = p8_json($status);
	
	include template($this_module, 'list', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$action =  isset($_POST['action'])? $_POST['action'] : '';
	
	if($action == 'check_status'){
		
		$id =  isset($_POST['id']) ? intval($_POST['id']) : '';
		$data = $this_module->DB_master->fetch_one("SELECT id, status,recommend, reply FROM $this_module->table WHERE id = '$id'");
		exit(p8_json($data));
		
	}else if($action == 'set_status'){
		$id =  isset($_POST['id']) ? filter_int($_POST['id']) : array();
		$oid = isset($_POST['oid']) ? intval($_POST['oid']) : '';
		$status = isset($_POST['status']) ? intval($_POST['status']) : '';
		$recommend = isset($_POST['recommend']) ? intval($_POST['recommend']) : '';
		$reply = isset($_POST['reply']) ? from_utf8(p8_html_filter($_POST['reply'])) : '';
		if(!$id && !$oid )exit('[]');
		$realarray = $oid? array($oid) : $id;
		
		$resule = $this_module->status(array(
			'ids' => implode(",",$realarray),
			'reply' => $reply,
			'recommend' => $recommend,
			'status' => $status,
			'replyer' => $USERNAME
		));
		
		
		exit(p8_json($resule));
		
	}else if($action == 'verify'){
		
		$id =  isset($_POST['id']) ? filter_int($_POST['id']) : array();
		$oid = isset($_POST['oid']) ? intval($_POST['oid']) : '';
		$ov = isset($_POST['ov']) ? intval($_POST['ov']) : '';
		if(!$id && !$oid )exit('[]');
		$realarray = $oid? array($oid) : $id;
		
		$resule = $this_module->verify(array(
			'ids' => implode(",",$realarray),
			'ov' => $ov
		));
		
		
		exit(p8_json($resule));
		
	}else if($action == 'delete'){
		$id =  isset($_POST['id']) ? filter_int($_POST['id']) : array();
		$oid = isset($_POST['oid']) ? intval($_POST['oid']) : '';
		$mid = isset($_POST['mid']) ? intval($_POST['mid']) : '';
		if(!$id && !$oid || !$mid)exit('[]');
		$this_module->set_model($mid);
		$realarray = $oid? array($oid) : $id;
		
		$resule = $this_module->delete(array('ids' => $realarray));
		
		exit(p8_json($resule));
		
	}else if($action == 'displayorder'){
		//批量修改字段的排序
		$display_order = isset($_POST['_display_order']) && is_array($_POST['_display_order']) ? array_map('intval', $_POST['_display_order']) : array();
		
		foreach($display_order as $id => $order){
			$DB_master->update(
				$this_module->table,
				array(
					'display_order' => $order
				),
				"id = '$id'"
			);
		}
		exit("[]");
	}
}