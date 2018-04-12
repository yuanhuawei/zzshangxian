<?php
defined('PHP168_PATH') or die();

//$this_controller->check_action($ACTION) or message('no_privilege');

$page_url = $this_router . '-' . $ACTION;
$page = 1;
$_data = $page_url_params = $current_category = $list_top = $parent_category = $parent_ids = $children_ids = $CATEGORY = array();
$filter = $position = '';

//载入分类模块
$category = &$this_system->load_module('category');
$category -> get_cache();

$select = select();
$select->from($this_module->table .' AS T', 'T.*');
$select->in('T.verify', 1);

foreach($URL_PARAMS as $k => $v){
	switch($v){
		case 'filter':
			$filter = isset($URL_PARAMS[$k+1]) ? $URL_PARAMS[$k+1] : '';
			//未解决
			if($filter == 'unsolved'){
				$select->in('T.status', 3, true);
				$select->order('T.addtime DESC');
			}
			//已解决
			elseif($filter == 'solve'){
				$select->in('T.status', 3);
				$select->order('T.slovetime DESC');
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
			//点击排行
			elseif($filter == 'view'){
				$select->order('T.views DESC');
			}
			break;
		
		//关键词搜索
		case 't':
			$_title = isset($URL_PARAMS[$k+1]) ? base64_decode($URL_PARAMS[$k+1]) : '';
			$title = from_utf8($_title);
			$select->like('T.title', $title);
			$page_url_params['t'] = base64_encode($_title);
			break;

		case 'page':
			$page = isset($URL_PARAMS[$k+1]) ? intval($URL_PARAMS[$k+1]) : 1;
			$page = max(1, $page);
			break;
	}
}

if(!in_array($filter, array('unsolved','solve','recommend','credit','view'))){
	$select->order('T.id DESC');
}
else{
	$page_url_params['filter'] = $filter;
}

$page_url_params['page'] = '?page?';
$page_url .= page_url($page_url_params);
$count = 0;
$list = $core->list_item(
	$select,
	array(
		'page' => &$page,
		'count' => &$count,
		'page_size' => intval($this_system->CONFIG['perpage'])/*,
		'sphinx' => $this_module->CONFIG['sphinx']*/
	)
);


//导航位置
$position = '<a href="' . $this_system->controller . '">' . $this_system->sitename . '</a>' . '&nbsp;&gt;&nbsp;' . $P8LANG['ask_topics_list'];
//SEO
$sitename = $this_system->sitename . '-' . $this_system->sitetitle;
$keywords = $this_system->keywords;
$description = $this_system->description;

$pages = list_page(array(
	'count' => $count,
	'page' => $page,
	'page_size' => intval($this_system->CONFIG['perpage']),
	'url' => $page_url,
	'layout_size' => intval($this_system->CONFIG['layout_size']),
	'template' => $P8LANG['ask_page_template']
));

include template($this_module, 'all');