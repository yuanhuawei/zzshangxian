<?php
defined('PHP168_PATH') or die();

/**
* 个人主页CMS内容列表
**/

$page = 1;
foreach($URL_PARAMS as $k => $v){
	switch($v){
	
	case 'category':
		$cid = isset($URL_PARAMS[$k +1]) ? intval($URL_PARAMS[$k +1]) : 0;
		
	break;
	
	case 'page':
		$page = isset($URL_PARAMS[$k +1]) ? intval($URL_PARAMS[$k +1]) : 1;
		$page = max($page, 1);
	break;
	
	}
}

$select = select();
$select->from($this_module->main_table .' AS i', 'i.id, i.model, i.title, i.title_color, i.title_bold, i.sub_title, i.cid, i.frame, i.url, i.uid, i.username, i.attributes, i.summary, i.html_view_url_rule, i.views, i.comments, i.timestamp');
$select->inner_join($this_module->member_table .' AS m', '', 'm.iid = i.id');

$select->in('m.uid', $USER['id']);
$select->order('m.timestamp DESC');

$count = 0;
$page_size = 20;

$list = $core->list_item(
	$select,
	array(
		'page' => &$page,
		'page_size' => $page_size,
		'count' => &$count
	)
);

$category = &$this_system->load_module('category');
$category->get_cache();

foreach($list as $k => $v){
	$v['#category'] = &$category->categories[$v['cid']];
	$list[$k]['url'] = p8_url($this_module, $v, 'view');
	
	$list[$k]['frame'] = attachment_url($v['frame']);
	
	//分类名称
	$list[$k]['category_name'] = $v['#category']['name'];
	//分类URL
	$list[$k]['category_url'] = $v['#category']['url'];
	
	//加粗和颜色
	if(!empty($v['title_color'])) $list[$k]['title'] = '<font color="'. $v['title_color'] .'">'. $list[$k]['title'] .'</font>';
	if(!empty($v['title_bold'])) $list[$k]['title'] = '<b>'. $list[$k]['title'] .'</b>';
}
//echo $select->build_sql();


$data = array('URL' => $this_url, '#category' => array());
$page_url = p8_url($this_module, $data, 'homepage_list', false);

//echo $page_url;
$pages = list_page(array(
	'count' => $count,
	'page' => $page,
	'page_size' => $page_size,
	'url' => $page_url
));

$TITLE = p8lang($P8LANG['cms_item_list_of_somebody'], $USER['username']);
echo template($this_module, 'list');
include template($this_module, 'list');