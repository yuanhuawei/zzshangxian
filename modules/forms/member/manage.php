<?php
defined('PHP168_PATH') or die();

/**
* 我管理的表单
**/

$this_controller->check_action($ACTION) or message('no_privilege');
$my_forms_manage = $this_controller->get_acl('my_forms_manage');
$mids = $my_forms_manage? array_keys($my_forms_manage) : array();
if(REQUEST_METHOD == 'GET'){
	$mid = $_mid = isset($_GET['mid'])? intval($_GET['mid']) : 0;
	if($mid){
			$mids = $mid;
			$this_module->set_model($mid) or message('no_such_model');
	}
	if(empty($mids) && !$mid && !$IS_FOUNDER)message('no_privilege');
	
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page = max(1, $page);
	$page_url = $this_router .'-'. $ACTION .'?page=?page?';
	$page_url .="&mid=$mid";
	$count = 0;
	$select = select();
	$select -> from("$this_module->table as i",'i.*');
	if($IS_FOUNDER && $mid || !$IS_FOUNDER)$select -> in('i.mid',$mids);

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

	$select -> order('i.id DESC');
//echo $select->build_sql();	
	$list = $core->list_item(
		$select,
		array(
			'page' => &$page,
			'count' => &$count,
			'page_size' => 20
		)
	);
	foreach($list as $key=>$detail){
		$this_module->format_data($list[$key],36);
		$this_module->format_view($list[$key]);
		$list[$key]['url'] = p8_url($this_module,$detail,'view');
	}
	if(P8_AJAX_REQUEST){
		$page_url = $this_url .'?';
		$page_url = 'javascript:IntraForms.request_item(?page?,'.$mid.')';
		$json = p8_json(
			array('list'=>$list, 
				'pages'=>list_page(array(
				'count' => $count,
				'page' => $page,
				'page_size' => 20,
				'url' => $page_url
			))
			
			));
		exit($json);
	}
	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => 20,
		'url' => $page_url
	));

	$manage = $this_controller->check_action('manage');
	$my_addible_forms = $manage? $this_controller->get_acl('my_forms_manage') : $this_controller->get_acl('my_forms_post');
	$models = $this_module->core->CACHE->read('core/modules', 'forms', 'models');
	if(!isset($my_addible_forms[0]) && !$IS_FOUNDER){
		foreach($models as $mname => $mdata){
			if(!array_key_exists($mdata['id'],$my_addible_forms))
			unset($models[$mname]);
		}
	}
	$status = $this_module->CONFIG['status'];
	//$statuses = $this_module->get_statuses();
	$status_json = p8_json($status);
	include template($this_module, 'manage');
	
}else if(REQUEST_METHOD == 'POST'){
	$action =  isset($_POST['action'])? $_POST['action'] : '';
	
	if($action == 'check_status'){
		$id =  isset($_POST['id']) ? intval($_POST['id']) : '';
		$data = $this_module->DB_master->fetch_one("SELECT id, status, reply FROM $this_module->table WHERE id = '$id'");
		exit(p8_json($data));
	}else
	if($action == 'set_status'){
		$id =  isset($_POST['id']) ? filter_int($_POST['id']) : array();
		$oid = isset($_POST['oid']) ? intval($_POST['oid']) : '';
		$status = isset($_POST['status']) ? intval($_POST['status']) : '';
		$reply = isset($_POST['reply']) ? from_utf8(p8_html_filter($_POST['reply'])) : '';
		if(!$id && !$oid )exit('[]');
		$realarray = $oid? array($oid) : $id;
		
		$resule = $this_module->status(array(
			'ids' => implode(",",$realarray),
			'reply' => $reply,
			'status' => $status,
			'replyer' => $USERNAME
		));
		
		
		exit(p8_json($resule));
		
	}else
	if($action == 'delete'){
		$id =  isset($_POST['id']) ? filter_int($_POST['id']) : array();
		$oid = isset($_POST['oid']) ? intval($_POST['oid']) : '';
		$mid = isset($_POST['mid']) ? intval($_POST['mid']) : '';
		if(!$id && !$oid || !$mid)exit('[]');
		$this_module->set_model($mid);
		$realarray = $oid? array($oid) : $id;
		
		$resule = $this_module->delete(array('ids' => $realarray));
		
		
		exit(p8_json($resule));
		
	}
	
	


}