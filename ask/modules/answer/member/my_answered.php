<?php
defined('PHP168_PATH') or die();

//$this_controller->check_action($ACTION) or message('no_privilege');

if(empty($UID)){
	message('not_login');
}
GetGP(array('job','page','cid'));
$filter = $page_url = '';
$list = array();
$page = 1;
$count = 0;

//载入分类模块
$category = &$this_system->load_module('category');
$category -> get_cache();


$select = select();
$select->from($this_module->table . ' AS A', 'A.*,A.id AS aid');
$select->inner_join($this_module->table_item . ' AS I', 'I.id,I.title,I.uid AS puid,I.username AS pusername,I.cid,I.replies,I.addtime,I.status', 'I.id=A.tid');
$select->in('A.uid', $UID);
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
}

$pages = list_page(array(
	'count' => $count,
	'page' => $page, 
	'page_size' => 20, 
	'url' => $this_router.'-'.$ACTION.'-page-?page?-filter-'.$filter,
	'layout_size' => intval($this_system->CONFIG['layout_size']),
	'template' => $P8LANG['ask_page_template']
));

include template($this_module, 'my_answered');