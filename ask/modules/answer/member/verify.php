<?php
defined('PHP168_PATH') or die();

$this_controller->check_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
$job = isset($_GET['job'])? p8_html_filter($_GET['job']) : 'unverify';
$page = isset($_GET['page'])? intval($_GET['page']) : 1;
$page_url = $this_router .'-'. $ACTION .'?page=?page?';
$list = array();
$page = max($page, 1);
$count = 0;

//载入分类模块
$category = &$this_system->load_module('category');
$category -> get_cache();


$select = select();
$select->from($this_module->table . ' AS A', 'A.*,A.id AS aid');

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

$select->left_join($this_module->table_data . ' AS D', 'D.content','D.id=A.id');
$select->left_join($this_module->table_item . ' AS I', 'I.id, I.title,I.cid', 'A.tid=I.id');
switch($job){
	case 'verify'://被采纳的回答 
		$select -> in('A.verify', 1);
		$select->order('a.id DESC');
		$verify_over='over';
		break;
	case 'best'://优秀回答
		$select->in('A.bestanswer', 1);
		$select->order('A.addtime DESC');
		$best_over='over';
		break;
	case 'unverify'://未审核
		$select->in('A.verify', 0);
		$select->order('A.id DESC');
		$unverify_over='over';
		break;
	default:
		$select->order('A.id DESC');
		$all_over='over';
	
}
$page_url .= '&job='.$job;
if(!empty($cid))$select->in('I.cid',$cid);
//echo $select->build_sql();
$list = $core->list_item(
	$select,
	array(
		'page' => &$page,
		'count' => &$count,
		'page_size' => 20
	)
);

foreach($list as $k=>$v){
	$list[$k]['url'] = p8_url($this_module, $list[$k], 'view');
	$list[$k]['small_content'] = p8_cutstr(p8_html_filter($v['content']),25);
	$list[$k]['small_title'] = p8_cutstr(p8_html_filter($v['title']),25);
}

$pages = list_page(array(
	'count' => $count,
	'page' => $page, 
	'page_size' => 20, 
	'url' => $page_url,
	'layout_size' => intval($this_system->CONFIG['layout_size']),
	'template' => $P8LANG['ask_page_template']
));

include template($this_module, 'verify');
}else if(REQUEST_METHOD == 'POST'){
	$action =  isset($_POST['action'])? $_POST['action'] : '';
	
	if($action == 'delete_item'){
		$this_controller->check_action('delete') or exit("['no_privilege']");
		$id =  isset($_POST['id']) ? filter_int($_POST['id']) : array();
		$oid = isset($_POST['oid']) ? intval($_POST['oid']) : '';
		if(!$id && !$oid)exit('[]');
		$ids = $oid? array($oid) : $id;

		$param = array('ids' => $ids);
		$resule = $this_controller->delete($param);
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