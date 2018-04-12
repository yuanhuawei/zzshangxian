<?php
defined('PHP168_PATH') or die();


/**
* 专题页入口文件
**/
$id = 0;
foreach($URL_PARAMS as $k => $v){
	switch($v){
		case 'id':
			$id = isset($URL_PARAMS[$k +1]) ? intval($URL_PARAMS[$k +1]) : 0;
			$PAGE_CACHE_PARAM['id'] = $id;
			break 2;
		break;
	}
}
$id or message('no_such_item');


//页面缓存参数
$PAGE_CACHE_PARAM['ttl'] = empty($this_module->CONFIG['view_page_cache_ttl']) ? 0 : $this_module->CONFIG['view_page_cache_ttl'];
page_cache($PAGE_CACHE_PARAM);

$select = select();
$select->from($this_module->table, '*');
$select->in('id', $id);
$data = $core->select($select, array('single' => true));
$data or message('no_such_item');

$data['navigation'] = unserialize($data['navigation']);
$data['banner'] = attachment_url($data['banner']);
$data['frame'] = attachment_url($data['frame']);

$TP = $this_controller->gettemplate($data['template']);

//标签后缀
$LABEL_POSTFIX = array('sp_'.$id);

//分类自定义的内容页模板

//SEO
$TITLE = $data['title'] .' - '. $core->CONFIG['site_name'];
$SEO_KEYWORDS =$data['title'].'-'.$data['seo_keywords'];
$SEO_DESCRIPTION = $data['title'].'-'.$data['description'];

include template($this_module, $TP['main']);

//保存页面缓存
page_cache();
?>