<?php
defined('PHP168_PATH') or die();

/**
* 查看内容
* @language [cms/item/global.php]
**/

//页面缓存参数
$PAGE_CACHE_PARAM['ttl'] = empty($this_module->CONFIG['view_page_cache_ttl']) ? 0 : $this_module->CONFIG['view_page_cache_ttl'];
page_cache($PAGE_CACHE_PARAM);

//读取数据
if($verified){
	//己审核
	if(defined('P8_GENERATE_HTML') && !empty($HTML_DATA)){
		$data = &$HTML_DATA;
	}else{
		$data = array_merge($DB_slave->fetch_one($SQL), $data);
	}
}else{
	//未审核的数据
	
	$_data = mb_unserialize($data['data']);
	$data = array_merge($_data['addon'], $_data['item'], $_data['main']);
	unset($_data);
}

//格式化数据
$this_module->format_data($data);

$category = &$this_system->load_module('category');

$category->get_cache();
$cid = &$data['cid'];
$parent_cats = $category->get_parents($cid);

//本栏目相关
$select = select();
$select->from($this_module->table .' AS i', 'i.*');
$select->in('i.cid', $cid);
$select->order('i.timestamp DESC');
$select->limit(0, 4);
$listdb = $core->select($select);

foreach($listdb as $key => $val){
	$val['#category'] = &$CAT;
	$listdb[$key]['frame'] = attachment_url($val['frame']);
	$listdb[$key]['full_title'] = $val['title'];
	$listdb[$key]['title'] = p8_cutstr($val['title'], 120);
	$listdb[$key]['url'] = p8_url($this_module, $val, 'view');
}

/*
if(defined('P8_GENERATE_HTML') && $page == 1){
	//生成静态的时候,如果遇到第一页,把其余页的也生成
	
	require_once PHP168_PATH .'inc/html.func.php';
	$___tmp_file___ = p8_html_url($this_module, $data, 'view', false);
	//取路径
	$___path___ = str_replace(basename($___tmp_file___), '', $___tmp_file___);
	//分页文件
	$___page_file___ = preg_replace('/#([^#]+)#/', '\1', $___tmp_file___);
	
	for($___page___ = 2; $___page___ <= $video_count; $___page___++){
		//改URL路由
		$_SERVER['_REQUEST_URI'] = '/index.php/'. $SYSTEM .'/item-view-id-'. $id .'-page-'. $___page___;
		$___file___ = str_replace('?page?', $___page___, $___page_file___);
		
		ob_start();
		require PHP168_PATH .'index.php';
		$___content___ = ob_get_clean();
		
		//创建文件夹
		md($___path___);
		//生成文件
		write_file($___file___, $___content___);
	}
}*/