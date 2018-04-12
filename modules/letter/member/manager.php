<?php
defined('PHP168_PATH') or die();
$this_controller->check_action($ACTION) or message('no_privilege');
GetGP(array('act'));

$act = $act? $act : 'search';
if($act=='search'){
    $fengfa=-1;
	GetGP(array('status','page','action','keyword','type','department','act','comment','undisplay','fengfa'));
	
	$select = select();
	
	$my_manage = $this_controller->getcatbyAct('my_letter_manage');
	$display = $this_controller->check_action('display');
	$cates = $this_module->get_category();
//print_r($my_manage);
	$acl_where = $split = '';
	if(!$IS_FOUNDER){
		
		$my_manage = $this_controller->getcatbyAct('manager');
		$cates['department'] = $my_manage;
		if(!$my_manage)
			message('no_privilege');
		if(array_key_exists('0',$my_manage))
		;
		elseif(!array_key_exists('0',$my_manage)){
			$deps = array_keys($my_manage);
			$select->in('department',$deps);
		}else
			message('no_privilege');
	}

	$select->from($this_module->table, 'id,department,type,undisplay,number,username,create_time,title,status,solve_name');
	
	if($status>='0' && $status!=null)$select->in('status',trim($status));
	if(!empty($department))$select->in('department',trim($department));
	if(!empty($type))$select->in('type',trim($type));
	if($fengfa!=-1  && $fengfa!=null)$select->in('fengfa',trim($fengfa));
	if(!empty($comment))$select->in('comment',trim($comment));
	if(!empty($keyword))$select->like('title',trim($keyword));
	if($undisplay>='0')$select->in('undisplay',trim($undisplay));
	$select->order('create_time DESC');

	if($act=='search'){
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page = max(1, $page);
	}else{
		$page = 0;
	}

	$page_url = $this_router .'-'. $ACTION .'?page=?page?';
	//echo $select->build_sql();
	$count = 0;
	$list = $core->list_item(
		$select,
		array(
			'page' => &$page,
			'count' => &$count,
			'page_size' => 20
		)
	);

	$act=='search' && $pages = list_page(array(
			'count' => $count,
			'page' => $page,
			'page_size' => 20,
			'url' => $page_url
		));
	$ptitle = $P8LANG['list'];	
	
	$id_type = $this_module->id_type();
	
	$mana_message = $this_controller->manageMessage();

	include template($this_module, "manager");
}
elseif($act=='delete'){
	
	$ids = $_POST['id'];
	if(!$ids)
		message('error',$this_url);
	
	$dids = array();
	foreach($ids as $id){
		$data = $this_module->getData($id);
		if($this_controller->check_acl('delletter',$data['department']))
			$dids[]=$id;
	}
	if($dids)
		$this_module->delete(array('ids'=>$dids));
	
	message(
		array(
				array('to_list', $this_router .'-manager'),
				array('colsed', "javascript:window.close();"),
			),
			$this_router .'-manager',
			3000
		);
}
elseif($act=='del'){
	$id= intval($_GET['id']);
	$data = $this_module->getData($id);
	$this_controller->check_acl('delletter',$data['department']) or	message('no_privilege');
		
	$param = array('ids'=>array($id));
	$this_module->delete($param);

	message(
		array(
				array('to_list', $this_router .'-manager'),
				array('colsed', "javascript:window.close();"),
			),
			$this_router .'-manager',
			3000
		);
}
elseif($act=='verify'){
	$ids = $_POST['id'];
	if(!$ids)
		message('error',$this_url);
	
	$dids = array();
	foreach($ids as $id){
		$data = $this_module->getData($id);
		if($data['status']==0 && $this_controller->check_acl('vefify',$data['department']))
			$dids[]=$id;
	}
	if($dids)
		$this_module->verify(array('ids'=>$dids));
	
	message(
		array(
				array('to_list', $this_router .'-manager'),
				array('colsed', "javascript:window.close();"),
			),
			$this_router .'-manager',
			3000
		);
}

?>