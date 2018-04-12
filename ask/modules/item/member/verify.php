<?php
defined('PHP168_PATH') or die();

$this_controller->check_action($ACTION) or message('no_privilege');
if(REQUEST_METHOD == 'GET'){
$page = isset($_GET['page'])? intval($_GET['page']) : 1;
$job = isset($_GET['job'])? p8_html_filter($_GET['job']) : 'unsolve';
$cid = isset($_GET['cid'])? intval($_GET['cid']) : 0;

$page = max($page, 1);

$page_url = $this_router .'-'. $ACTION .'?page=?page?';
$count = 0;


$select = select();
$select -> from($this_module->table.' AS i','i.*');
//我可以审核的栏目
$my_category_to_verify = $this_controller->get_acl('my_category_to_verify');
if(isset($my_category_to_verify[0]) || $IS_FOUNDER){
	if($cid)$select->in('i.cid',$cid);
}elseif(!empty($my_category_to_verify)){
	$my_category_to_verify =array_keys($my_category_to_verify);
	if($cid && in_array($cid, $my_category_to_verify))$select->in('i.cid', $cid);
	else $select->in('i.cid', $my_category_to_verify);

}else{
message('no_category_privilege');
}
	switch($job){
		case 'solve':
			$select->where("( i.status = '3'  OR i.endtime <'". P8_TIME."' OR i.closed = '1')");
			$select->order('i.solvetime DESC');
			$solve_over='over';
			break;	
		case 'unsolve':
			$select->in('i.status',3,true);
			$select->in('i.verify',1);
			$select->where_and();
			$select->where("i.endtime >'". P8_TIME."'");
			$select->where_and();
			$select->where("i.closed = '0'");
			$select->order('i.id DESC');
			$unsolve_over='over';
			break;
		case 'unverify':
			$select->in('i.verify',0);
			$select->order('i.id DESC');
			$unverify_over='over';
			break;
		default:
			$select->in('i.uid',$UID);
			$select->order('i.id DESC');
			
	}
if(!empty($cid))$select->in('i.cid',$cid);
$page_url .= '&job='.$job;
//echo $select->build_sql();
//取数据
$list = $core->list_item(
	$select,
	array(
		'page' => &$page,
		'count' => &$count,
		'page_size' => 20,
		'ms' => 'master'
	)
);

foreach($list as $k=>$v){
	$list[$k]['url'] = p8_url($this_module, $list[$k], 'view');
}
//分页
$pages = list_page(array(
	'count' => $count,
	'page' => $page,
	'page_size' => 20,
	'url' => $page_url
));

/* $member = $this_system->load_module('member');
$is_expertor = $member->check_exists_expertor(" uid = '$UID'");*/
//载入分类模块
$category = &$this_system->load_module('category');
$category->get_cache(); 

include template($this_module, 'verify');
}else if(REQUEST_METHOD == 'POST'){
	$action =  isset($_POST['action'])? $_POST['action'] : '';
	
	if($action == 'delete_item'){
		$this_controller->check_action('delete') or exit("['no_privilege']");
		$id =  isset($_POST['id']) ? filter_int($_POST['id']) : array();
		$oid = isset($_POST['oid']) ? intval($_POST['oid']) : '';
		if(!$id && !$oid)exit('[]');
		$_ids = $oid? array($oid) : $id;
		
		$odata = $this_module->DB_master->fetch_all("SELECT id, cid FROM $this_module->table WHERE id in(".implode(",",$_ids).")");
		foreach($odata as $key => $detail){
			if($this_controller->check_category_action('delete', $detail['cid']))$ids[]=$detail['id'];
		
		}
		if(sizeof($ids)<1)exit("['no_category_privilege']");
		$param = array('ids' => $ids);
		//$resule = $this_controller->delete($param);
		exit(p8_json($resule));
	
	}else if($action == 'verify'){
		$id =  isset($_POST['id']) ? filter_int($_POST['id']) : array();
		$oid = isset($_POST['oid']) ? intval($_POST['oid']) : '';
		$verify = isset($_POST['verify']) ? intval($_POST['verify']) : '';
		if(!$id && !$oid )exit('[]');
		$ids = $oid? array($oid) : $id;
		$param =array(
			'ids' => $ids,
			'verify' => $verify
		);
		 $resule = $this_controller->verify($param); 
		
		
		exit(p8_json($resule));
	}	
}
