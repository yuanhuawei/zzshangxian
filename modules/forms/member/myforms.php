<?php
defined('PHP168_PATH') or die();

/**
* 我的表单
**/

//$this_controller->check_action($ACTION) or message('no_privilege');
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page = max(1, $page);
	$page_url = $this_router .'-'. $ACTION .'?page=?page?';
	$count = 0;
	$select = select();
	$select -> from("$this_module->table as i",'i.*');
	$select -> in('i.uid',$UID);
	$select -> order('i.id DESC');
	$mid = $_mid = isset($_GET['mid'])? intval($_GET['mid']) : 0;
	if($mid){
			$this_module->set_model($mid) or message('no_such_model');
			$select -> in('i.mid',$mid);
			$page_url .="&mid=$mid";
	}
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
	$status = $this_module->CONFIG['status'];
	$my_addible_forms =  $this_controller->get_acl('my_forms_post');
	$models = $this_module->core->CACHE->read('core/modules', 'forms', 'models');
	if(!isset($my_addible_forms[0]) && !$IS_FOUNDER){
		foreach($models as $mname => $mdata){
			if(!array_key_exists($mdata['id'],$my_addible_forms))
			unset($models[$mname]);
		}
	}
	
	include template($this_module, 'myforms');