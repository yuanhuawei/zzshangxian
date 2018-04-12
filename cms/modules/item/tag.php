<?php
defined('PHP168_PATH') or die();

/**
* tag
**/

//message('建设中');

$tag = '';
$page = 1;
foreach($URL_PARAMS as $k => $v){
	switch($v){
	
	case 'name':
		$tag = isset($URL_PARAMS[$k +1]) ? from_utf8(urldecode($URL_PARAMS[$k +1])) : '';
		
	break;
	
	case 'page':
		$page = isset($URL_PARAMS[$k +1]) ? intval($URL_PARAMS[$k +1]) : 1;
		$page = max($page, 1);
	break;
	
	}
}

//exit;

$PAGE_CACHE_PARAM['tag'] = $tag;

//页面缓存参数: 更新时间
$PAGE_CACHE_PARAM['ttl'] = empty($this_module->CONFIG['list_page_cache_ttl']) ? 0 : $this_module->CONFIG['list_page_cache_ttl'];

if(strlen($tag) == 0){
	
	page_cache($PAGE_CACHE_PARAM);
	
	//all tag
	$select = select();
	$select->from($this_module->tag_table, '*');
	$select->order('display_order DESC');
	
	$page_url = $this_url .'-page-?page?';
	
	$count = 0;
	$page_size = 20;
	$list = $core->list_item(
		$select,
		array(
			'count' => &$count,
			'page' => &$page,
			'page_size' => $page_size
		)
	);
	
	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => $page_size,
		'url' => $page_url,
	));
	
	//print_R($list);
	
	$LABEL_POSTFIX = array('tag_list');
	
	include template($this_module, 'tag_list');
	
}else{
	
	$tmp = $this_module->get_tag(html_entities($tag), true);
	if(empty($tmp['tag_id'])) message('no_such_tag', $this_url);
	
	page_cache($PAGE_CACHE_PARAM);
	
	foreach($tmp['tag'] as $k => $v){
		unset($tmp['tag'][$k]);
		$tmp['tag'][strtolower($k)] = $v;
	}
	
	$select = select();
	$select->from($this_module->main_table .' AS m', 'm.*');
	$select->inner_join($this_module->tag_item_table .' AS ti', '', 'm.id = ti.iid');
	$select->in('ti.tid', $tmp['tag_id']);
	$select->order('ti.iid DESC');
	
	$page_url = $this_url .'-name-'. $tag .'-page-?page?';
	
	$count = $tmp['tag'][html_entities(strtolower($tag))]['item_count'];
	$page_size = 20;
	$list = $core->list_item(
		$select,
		array(
			'count' => &$count,
			'page' => &$page,
			'page_size' => $page_size
		)
	);
	
	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => $page_size,
		'url' => $page_url,
		'template' => $P8LANG['cms_page_template']
	));
	
	$category = &$this_system->load_module('category');
	$category->get_cache();
	
	foreach($list as $k => $v){
		$v['#category'] = &$category->categories[$v['cid']];
		$list[$k]['url'] = p8_url($this_module, $v, 'view');
		$list[$k]['frame'] = attachment_url($v['frame']);
		$list[$k]['full_title'] = $v['title'];
		$tmp = explode('|', $v['sub_title']);
		$list[$k]['sub_title'] = $tmp[0];
		$list[$k]['sub_title_url'] = isset($tmp[1]) ? $tmp[1] : '';
		
		//分类名称
		$list[$k]['category_name'] = $v['#category']['name'];
		//分类URL
		$list[$k]['category_url'] = $v['#category']['url'];
		
		if(!empty($v['title_color'])) $list[$k]['title'] = '<font color="'. $v['title_color'] .'">'. $list[$k]['title'] .'</font>';
		if(!empty($v['title_bold'])) $list[$k]['title'] = '<b>'. $list[$k]['title'] .'</b>';
	}
	
	//echo $select->build_sql();
	
	//print_R($list);
	
	$LABEL_POSTFIX = array('tag');
	
	include template($this_module, 'tag');
}

//保存页面缓存
page_cache();