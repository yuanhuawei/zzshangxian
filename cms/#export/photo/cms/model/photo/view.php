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


$multi_page = !empty($this_model['CONFIG']['multi_page']);

if($real_page == 1){
	//格式化数据
	$this_module->format_data($data);

	$category = &$this_system->load_module('category');
	$category->get_cache();

	$parent_cats = $category->get_parents($cid);
	
	//本栏目相关
	$select = select();
	$select->from($this_module->table .' AS i', 'i.*');
	$select->in('i.cid', $cid);
	$select->order('i.timestamp DESC');
	$select->limit(0, 6);
	$listdb = $core->select($select);

	foreach($listdb as $key => $val){
		$val['#category'] = &$CAT;
		$listdb[$key]['frame'] = attachment_url($val['frame']);
		$listdb[$key]['full_title'] = $val['title'];
		$listdb[$key]['title'] = p8_cutstr($val['title'], 12);
		$listdb[$key]['url'] = p8_url($this_module, $val, 'view');
	}
	
	$page_count = count($data['photourl']);
}

//
if(!defined('P8_GENERATE_HTML_PHOTO')){
	
}

//分页模式
if($multi_page){
	$link_pages = array();
	
	if(empty($data['photourl'][$real_page -1])){
		message('no_such_item');
	}else{
		$photo = $data['photourl'][$real_page -1];
	}
	
	$pages = $page_count > 1 ? 
		list_page(array(
			'count' => $page_count,
			'page' => $real_page,
			'page_size' => 1,
			'url' => $page_url,
			'template'=> !empty($CAT['CONFIG']['view_pages_template']) && isset($P8LANG[$CAT['CONFIG']['view_pages_template']]) ?
				$P8LANG[$CAT['CONFIG']['view_pages_template']] :
				$P8LANG['base_page_template'],
			'return_link' => array(
				'first_page' => &$first_page,
				'prev_page' => &$prev_page,
				'next_page' => &$next_page,
				'pages' => &$link_pages
			)
		)) :
		'';
	
	
	//html
	if(defined('P8_GENERATE_HTML') && $real_page == 1){
		
		//define('P8_GENERATE_HTML_PHOTO', true);
		
		$_next_page = $next_page;
		$_link_pages = $link_pages;
		
		//生成HTML
		require_once PHP168_PATH .'inc/html.func.php';
		$___count___ = $page_count;
		$___tmp_file___ = p8_html_url($this_module, $data, 'view', false);
		//取路径
		$___path___ = str_replace(basename($___tmp_file___), '', $___tmp_file___);
		//创建文件夹
		md($___path___);
		//分页文件
		$___page_file___ = preg_replace('/#([^#]+)#/', '\1', $___tmp_file___);
		
		for($___page___ = 2; $___page___ <= $___count___; $___page___++){
			//改URL路由
			$_SERVER['_REQUEST_URI'] = '/index.php/'. $SYSTEM .'/item-view-id-'. $id .'-page-'. $___page___;
			$this_module->_html['__file'] = str_replace('?page?', $___page___, $___page_file___);
			
			ob_start();
			require PHP168_PATH .'index.php';
			$___content___ = ob_get_clean();
			
			//生成文件
			write_file($this_module->_html['__file'], $___content___);
		}
		
		$photo = $data['photourl'][0];
		$next_page = $_next_page;
		$link_pages = $_link_pages;
		$real_page = 1;
	}
}