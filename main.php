<?php
defined('PHP168_PATH') or die();

if(
	!empty($core->CONFIG['forbidden_dynamic']) &&
	!($IS_ADMIN || $IS_FOUNDER || defined('P8_GENERATE_HTML'))
){
	//禁止查看动态页,生成静态管理员例外
	message('access_denied');
}

$PAGE_CACHE_PARAM['ttl'] = empty($core->CONFIG['index_page_cache_ttl']) ? 0 : $core->CONFIG['index_page_cache_ttl'];
page_cache($PAGE_CACHE_PARAM);

$LABEL_POSTFIX = array('index');

include template($core, 'index');

//保存页面缓存
page_cache();