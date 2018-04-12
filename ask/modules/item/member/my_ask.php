<?php
defined('PHP168_PATH') or die();

//$this_controller->check_action($ACTION) or message('no_privilege');
GetGP(array('job','page','cid'));

$job = $job? $job : 'unsolve';
$page = isset($page) ? intval($page) : 1;
$page = max($page, 1);

$page_url = $this_router .'-'. $ACTION .'?page=?page?';
$count = 0;
$member = $this_system->load_module('member');
$is_expertor = $member->check_exists_expertor(" uid = '$UID'");
//载入分类模块
$category = &$this_system->load_module('category');
$category->get_cache();

$select = select();
$select -> from($this_module->table.' AS i','i.*');


	switch($job){
		case 'solve':
			$select->in('i.uid',$UID);
			$select->where("( i.status = '3'  OR i.endtime <'". P8_TIME."' OR i.closed = '1')");
			$select->order('i.solvetime DESC');
			$solve_over='over';
			break;	
		case 'unsolve':
			$select->in('i.uid',$UID);
			$select->in('i.status',3,true);
			$select->in('i.verify',1);
			$select->where_and();
			$select->where("i.endtime >'". P8_TIME."'");
			$select->where_and();
			$select->where("i.closed != '1'");
			$select->order('i.id DESC');
			$unsolve_over='over';
			break;
		case 'recommend':
			$select->in('i.uid',$UID);
			$select->in('i.recommend',1);
			$select->order('i.lastpost DESC');
			$recommend_over='over';
			break;
		case 'unverify':
			$select->in('i.uid',$UID);
			$select->in('i.verify',0);
			$select->order('i.id DESC');
			$unverify_over='over';
			break;
		case 'askme':
			$select->in('i.to_uid',$UID);
			$select->order('i.id DESC');
			$askme_over='over';
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

$p8_time = P8_TIME;

include template($this_module, 'my_ask');
