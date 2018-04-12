<?php
defined('PHP168_PATH') or die();


/**
* 专题列表页入口文件
**/
$cid = 0;
$page = 1;
foreach($URL_PARAMS as $k => $v){
	switch($v){
		case 'category':
			$cid = isset($URL_PARAMS[$k +1]) ? intval($URL_PARAMS[$k +1]) : 0;
			$PAGE_CACHE_PARAM['cid'] = $cid;
			break 2;
		break;
		case 'page':
		$page = isset($URL_PARAMS[$k +1]) ? intval($URL_PARAMS[$k +1]) : 1;
		$page = max($page, 1);
	break;
	}
}
$cid or message('no_such_item');
$this_module->category->get_cache();
$CAT = $this_module->category->categories[$cid];
//页面缓存参数: cid
$PAGE_CACHE_PARAM['cid'] = $cid;

//页面缓存参数: page
$PAGE_CACHE_PARAM['page'] = $page;
//页面缓存参数
$PAGE_CACHE_PARAM['ttl'] = empty($this_module->CONFIG['view_page_cache_ttl']) ? 0 : $this_module->CONFIG['view_page_cache_ttl'];
page_cache($PAGE_CACHE_PARAM);

$count = 10;
$list = $CAT;
if(!empty($list['categories'])){
	
	foreach($list['categories'] as $key => $rs){
		if($key>5)break;
		$list['categories'][$key]['data']=$this_module->fetch_item($rs['id'],array('count'=>$count));
		$list['categories'][$key]['url'] = p8_url($this_module, $rs, 'list');
	}


}else{
	$page_url=$this_url;
	$list['data']=$this_module->fetch_item(
		$list['id'],
		array(
			'count' => $count,
			'page' => $page,
			'page_size' => 10,
		)
	);
	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => 10,
		'url' => $page_url
	));
}

//标签后缀
$LABEL_POSTFIX = array('sp_'.$cid);

//分类自定义的内容页模板
//seo
//SEO
$TITLE = $CAT['name'] .' - '. $core->CONFIG['site_name'];
$SEO_KEYWORDS =$CAT['name'];
$SEO_DESCRIPTION = $CAT['name'];

include template($this_module, 'list');
//保存页面缓存
page_cache();
?>