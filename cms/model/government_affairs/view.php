<?php
defined('PHP168_PATH') or die();

/**
* �鿴����
* @language [cms/item/global.php]
**/

//ҳ�滺�����
$PAGE_CACHE_PARAM['ttl'] = empty($this_module->CONFIG['view_page_cache_ttl']) ? 0 : $this_module->CONFIG['view_page_cache_ttl'];
page_cache($PAGE_CACHE_PARAM);


//��ȡ����
if($verified){
	//�����
	if(defined('P8_GENERATE_HTML') && !empty($HTML_DATA)){
		$data = &$HTML_DATA;
	}else{
		$data = array_merge($DB_slave->fetch_one($SQL), $data);
	}
}else{
	//δ��˵�����
	
	$_data = unserialize($data['data']);
	$data = array_merge($_data['addon'], $_data['item'], $_data['main']);
	unset($_data);
}

//��ʽ������
$this_module->format_data($data);

$category = &$this_system->load_module('category');
$category->get_cache();

$parent_cats = $category->get_parents($cid);

$data['#category'] = &$CAT;