<?php
defined('PHP168_PATH') or die();

/**
* CMS内容搜索
**/

$this_controller->check_action($ACTION) or message('no_privilege');

$models = $this_system->get_models(true);

$model = isset($_GET['model']) && isset($models[$_GET['model']]) ? $_GET['model'] : '';
if($model){
	if(!isset($models[$model])){
		message('no_such_cms_model');
	}else{
		$this_module->set_model($model);
	}
}

$pages = '';
$count = 0;
$search_type = isset($_GET['search_type']) ? intval($_GET['search_type']) : 0;
$starttime = isset($_GET['starttime']) ? (trim($_GET['starttime'])!='' ? strtotime(trim($_GET['starttime']).' 0:0:0') : '') : strtotime("-36 Months");
$endtime = isset($_GET['endtime']) ? (trim($_GET['starttime'])!='' ? strtotime(trim($_GET['endtime']).' 23:59:59') : '') : time();

//关键字
$keyword = isset($_GET['keyword']) ? p8_stripslashes2(trim($_GET['keyword'])) : '';
if(!strlen($keyword)){
	include template($this_module, 'search');exit;
}
$year = isset($_GET['year']) ? p8_stripslashes2(trim($_GET['year'])) : '';
if($year){
	$starttime = strtotime($year.'-1-1 0:0:0');
	$endtime = strtotime($year.'-12-31 23:59:59');
}
$page_url = $year_url = $this_url .'?keyword='. urlencode($keyword);
$page_url .= '&page=?page?';
if($year) $page_url .= '&year=?year?';
$year_url .= '&page='.$page.'&search_type='.$search_type.'&model='.$model.'&year=';

$cid = isset($_GET['cid']) ? intval($_GET['cid']) : 0;

$order = isset($_GET['order']) ? $order : 0;

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page = max($page, 1);

$sphinx = empty($this_module->CONFIG['sphinx']['enabled']) ? false : true;

//加载分类模块
$category = &$this_system->load_module('category');
$category->get_cache();

if(is_file($this_system->path .'model/'. $model .'/search.php')){
	//模型自定义有搜索脚本,跳转过去
	
	$_REQUEST['model'] = $model;
	$this_system->init_model();
	require $this_system->path .'model/'. $model .'/search.php';
	exit;
}

$select = select();

//有分类
if($cid){
	$cids = array($cid);
	if(isset($category->categories[$cid]['categories'])){
		$cids = $category->get_children_ids($cid) + $cids;
	}
	$select->in('i.cid', $cids);
}

$keyword = html_entities($keyword);

$page_size = 10;


$T = $model ? $this_module->table : $this_module->main_table;
if($sphinx){
	//如果是sphinx搜索
	
	$select->from($T. ' AS i', 'i.*');
	
	//sphinx的搜索字段可以随意
	$select->like('i.id', $keyword);
	$select->order('i.timestamp DESC');
	
	//sphinx模型索引
	$sphinx_indexes = $this_system->sphinx_indexes($model ? array($model => 1) : array());
	
	$sphinx = $this_module->CONFIG['sphinx'];
	$sphinx['index'] = $sphinx_indexes;
	
	//取数据
	$list = &$core->list_item(
		$select,
		array(
			'page' => &$page,
			'count' => &$count,
			'page_size' => $page_size,
			'sphinx' => $sphinx
		)
	);
	
}else{	
	$select->from($T. ' AS i', 'i.*');
	switch($search_type){
		case '1':
			$select->search('i.title', $keyword);
		break;
		case '2':
			$select->search('i.summary', $keyword);
		break;
		case '3':
			$select->search('i.author', $keyword);
		break;
		case '4':
			$select->in('i.username', $keyword);
		break;
		default:		
			$select->search('i.title', $keyword);
			if($year){
				$select->where_and();
				$fromtime = $year ? strtotime($year.'-1-1 0:0:0') : 0;
				$totime = $year ? strtotime($year.'-12-31 23:59:59') : 0;
				$select->range('i.timestamp', $fromtime, $totime);
			}else{
				if($starttime || $endtime){
					$select->where_and();
					$starttime_r = $starttime == '' ? 0 : $starttime;
					$endtime_r = $endtime == '' ? 0 : $endtime;
					$select->range('i.timestamp', $starttime_r, $endtime_r);
				}
			}
			$select->where_or();
			$select->search('i.summary', $keyword);
			if($year){
				$select->where_and();
				$fromtime = $year ? strtotime($year.'-1-1 0:0:0') : 0;
				$totime = $year ? strtotime($year.'-12-31 23:59:59') : 0;
				$select->range('i.timestamp', $fromtime, $totime);
			}else{
				if($starttime || $endtime){
					$select->where_and();
					$starttime_r = $starttime == '' ? 0 : $starttime;
					$endtime_r = $endtime == '' ? 0 : $endtime;
					$select->range('i.timestamp', $starttime_r, $endtime_r);
				}
			}			
	}
	/*
	* 如果有年份，按年份
	*/
	if($search_type>0){
		if($year){
			$select->where_and();
			$fromtime = $year ? strtotime($year.'-1-1 0:0:0') : 0;
			$totime = $year ? strtotime($year.'-12-31 23:59:59') : 0;
			$select->range('i.timestamp', $fromtime, $totime);
		}else{
			if($starttime || $endtime){
				$select->where_and();
				$starttime_r = $starttime == '' ? 0 : $starttime;
				$endtime_r = $endtime == '' ? 0 : $endtime;
				$select->range('i.timestamp', $starttime_r, $endtime_r);
			}
		}
	}
	
	//取数据
	$count = 0;
	//取年份
	$get_year = $list_year = array();
	$select_year = select();
	$select_year->from($T. ' AS i', 'i.timestamp');	
	$select_year->order('i.timestamp DESC');
	$list_year = $core->list_item($select_year,array('page' => 0));
	foreach($list_year as $k => $v){
		$get_year[] = date('Y',$v['timestamp']);
	}
	$get_year = array_unique($get_year);
	
	$list = $core->list_item(
		$select,
		array(
			'page' => &$page,
			'count' => &$count,
			'page_size' => $page_size
		)
	);
}

//echo $select->build_sql();


$page_count = ceil($count / $page_size);
//分页
$pages = list_page(array(
	'count' => $count,
	'year' => $year,
	'page' => $page,
	'page_size' => $page_size,
	'url' => $page_url
));



//处理URL
foreach($list as $k => $v){
	$v['#category'] = &$category->categories[$v['cid']];
	
	$list[$k]['url'] = p8_url($this_module, $v, 'view');
	$list[$k]['frame'] = attachment_url($v['frame']);
	$list[$k]['summary'] = html_entity_decode($v['summary']);
	$list[$k]['summary'] = preg_replace('/(amp;)+/','', $list[$k]['summary']);
	//分类名称
	$list[$k]['category_name'] = $v['#category']['name'];
	//分类地址
	$list[$k]['category_url'] = $v['#category']['url'];
}
$usetime = substr(get_timer() - $P8['start_time'], 0, 7);

$LABEL_POSTFIX = array('search');

include template($this_module, 'search');