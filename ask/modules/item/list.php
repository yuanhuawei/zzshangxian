<?php
defined('PHP168_PATH') or die();

$this_controller->check_action($ACTION) or message('no_privilege');

$list = $LCID=$CAT = $page_url_params = $categories = $list_top = $parent_categories = $CATEGORY = array();
$filter = $position = '';
$page = 1;
$page_url_params['page'] = '?page?';
//历史记录时间
$history_expired_time = abs(intval($this_system->CONFIG['history_expired_days'])) * 86400;

if(!in_array('category', $URL_PARAMS)){
	message('ask_error', $this_system->controller, 3);
}

//载入分类模块
$category = &$this_system->load_module('category');
$category->get_cache(true);

$select = select();
$select->from($this_module->table .' AS T', 'T.*');
$select->in('T.verify', 1);

foreach($URL_PARAMS as $k => $v){
	switch($v){
		case 'category':
			$cid = isset($URL_PARAMS[$k+1]) ? intval($URL_PARAMS[$k+1]) : 0;
			//判断权限
			$this_controller->check_category_action($ACTION, $cid) or message('no_category_privilege');
			$CAT = $category->get_one(array('id'=>$cid), true) or message('ask_error', $this_system->controller, 3);

			
			//获取父分类
			$parent_categories = $category->get_parents($cid);
			//全部分类
			$CATEGORY = $category->get_children_ids($cid);
			array_unshift($CATEGORY, $cid);
			
			$CATEGORY = $this_controller->get_category_acl($ACTION,$CATEGORY);
			
			$CATEGORY or message('no_category_privilege');
			
			//当前所有分类列表
			if(isset($category->categories[$cid]['categories'])){
				$categories = $category->categories[$cid]['categories'];
			}else{
				if(empty($CAT['parent'])){
					$categories = $category->top_categories;
				}else{
					$categories = $category->categories[$CAT['parent']]['categories'];
				}
			}

			$select -> in('T.cid', $CATEGORY);
			break;

		case 'filter':
			$filter = isset($URL_PARAMS[$k+1]) ? $URL_PARAMS[$k+1] : '';
			//未解决
			if($filter == 'unsolved'){
				$select->in('T.status', 3, true);
				$select->where_and();
				$select->where("T.endtime >'". P8_TIME."'");
				$select->where_and();
				$select->where("T.closed = '0'");
				$select->order('T.addtime DESC');
			}
			//已解决
			elseif($filter == 'solve'){
				$select->in('T.status', 3);
				$select->where_or();
				$select->where("T.endtime <'". P8_TIME."'");
				$select->where_or();
				$select->where("T.closed = '1'");
				$select->order('T.solvetime DESC');
			}
			//推荐
			elseif($filter == 'recommend'){
				$select->in('T.recommend', 1);
				$select->order('T.lastpost DESC');
			}
			//高分
			elseif($filter == 'credit'){
				$select->in('T.offercredit', 1);
				$select->order('T.addtime DESC');
			}
			//一周热点
			elseif($filter == 'week'){
				$select->range('T.addtime', P8_TIME-604800, P8_TIME);
				$select->order('T.views DESC');
			}
			//点击排行
			elseif($filter == 'view'){
				$select->order('T.views DESC');
			}
			break;

		case 'page':
			$page = isset($URL_PARAMS[$k+1]) ? intval($URL_PARAMS[$k+1]) : 1;
			$page = max(1, $page);
			break;
	}
}

//关键词搜索
$t = isset($_GET['t']) ? rawurldecode($_GET['t']) : '';
if(!empty($t)){
	$select->like('T.title', p8_addslashes($t));
}
$t = html_entities($t);
if(!in_array($filter, array('unsolved','solve','recommend','credit','week','view'))){
	$select->order('T.id DESC');
}
else{
	$page_url_params['filter'] = $filter;
}
$page_size=!empty($this_system->CONFIG['perpage'])? intval($this_system->CONFIG['perpage']):20;
$title_size = !empty($this_system->CONFIG['title_bytes'])? intval($this_system->CONFIG['title_bytes']):30;
$count = 0;
//echo $select->build_sql();
$list = $core->list_item(
	$select,
	array(
		'page' => &$page,
		'count' => &$count,
		'page_size' => $page_size
	)
);
foreach($list as $k=>$v){
	if($v['endtime']<P8_TIME && $v['status']!=3 || $v['closed'])$list[$k]['status']='c';
	$list[$k]['url'] = p8_url($this_module, $list[$k], 'view');
	$list[$k]['title'] = p8_cutstr($v['title'],$title_size);
}

$page_url = '';
foreach($page_url_params as $k => $v){
	$page_url .= '-'. $k .'-'. $v;
}

$pages = list_page(array(
	'count' => $count,
	'page' => $page, 
	'page_size' => $page_size, 
	'url' => $CAT['url'].$page_url,
	'layout_size' => intval($this_system->CONFIG['layout_size']), 
	'template' => $P8LANG['ask_page_template']
));

//置顶问题,第一页时显示
if($page == 1){
	$parent_ids = array();
	//父类ID
	foreach($parent_categories as $value){
		$parent_ids[] = $value['id'];
	}
	$list_top = $this_controller->get_displayorder_items(
			array(
				'cid'=>$cid,
				'categories' => array_merge($parent_ids,array($cid))
			)
		);
}

//导航位置
foreach($parent_categories as $v){
	$position .= '&nbsp;&gt;&nbsp;<a href="'. $v['url'] . '">' . $v['name'] . '</a>';
}
$position = $this_system->position . $position . '&nbsp;&gt;&nbsp;' . $CAT['name'];

//SEO
$sitename = $CAT['name'] . ' - ' . $this_system->sitename;
$meta_keywords = $CAT['keywords'] . ($CAT['keywords'] ? ',' : '') . $this_system->meta_keywords;
$meta_description = $CAT['description'] . ($CAT['description'] ? ',' : '') . $this_system->meta_description;
list($CAT['list_template'],$CAT['view_template'],$CAT['block_template'])= $this_controller->maketemplate($CAT['list_template'],$CAT['view_template'],$CAT['block_template']);
include template($this_module, $CAT['list_template']);