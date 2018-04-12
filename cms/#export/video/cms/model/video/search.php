<?php
defined('PHP168_PATH') or die();

/**
* 搜索视频
**/

$select = select();

//有分类
if($cid){
	$cids = array($cid);
	if(isset($category->categories[$cid]['categories'])){
		$cids = $category->get_children_ids($cid) + $cids;
	}
	$select->in('m.cid', $cids);
}

$keyword = html_entities($keyword);



if($sphinx){
	//如果是sphinx搜索
	
	$select->from($this_module->table. ' AS i', 'i.*');
	
	//sphinx的搜索字段可以随意
	$select->like('i.id', $keyword);
	$select->order('i.timestamp DESC');
	
	//sphinx当前模型的索引
	$sphinx_indexes = $this_system->sphinx_indexes($MODEL);
	
	$sphinx = $this_module->CONFIG['sphinx'];
	$sphinx['index'] = $sphinx_indexes;
	
	//取数据
	$count = 0;
	$list = &$core->list_item(
		$select,
		array(
			'page' => &$page,
			'count' => &$count,
			'page_size' => 20,
			'sphinx' => $sphinx
		)
	);
	
}else{
	
	$select->from($this_module->table. ' AS i', 'i.*');
	
	$select->search('i.title', $keyword);
	$select->where_or();
	$select->search('i.summary', $keyword);
	$select->order('i.timestamp DESC');
	
	//取数据
	$count = 0;
	$list = $core->list_item(
		$select,
		array(
			'page' => &$page,
			'count' => &$count,
			'page_size' => 20
		)
	);
}


//分页
$pages = list_page(array(
	'count' => $count,
	'page' => $page,
	'page_size' => 20,
	'url' => $page_url
));



//处理URL
foreach($list as $k => $v){
	$v['#category'] = &$category->categories[$v['cid']];
	
	$list[$k]['url'] = p8_url($this_module, $v, 'view');
	$list[$k]['frame'] = attachment_url($v['frame']);
	
	//分类名称
	$list[$k]['category_name'] = $v['#category']['name'];
	//分类地址
	$list[$k]['category_url'] = $v['#category']['url'];
}

include template($this_module, 'video/search');