<?php
defined('PHP168_PATH') or die();

/**
* CMS首页
**/

if(
	!empty($this_system->CONFIG['forbidden_dynamic']) &&
	!($IS_ADMIN || $IS_FOUNDER || defined('P8_GENERATE_HTML'))
){
	//禁止查看动态页,生成静态管理员例外
	//message('access_denied');
	header('Location: '. ($core->CONFIG['index_system'] == $SYSTEM ? $core->url : $this_system->url));
	exit;
}

//页面缓存参数: 系统首页
$PAGE_CACHE_PARAM['system_index'] = 'cms';
$PAGE_CACHE_PARAM['mobile'] = $core->ismobile;

//页面缓存
$PAGE_CACHE_PARAM['ttl'] = empty($this_system->CONFIG['index_page_cache_ttl']) ? 0 : $this_system->CONFIG['index_page_cache_ttl'];
page_cache($PAGE_CACHE_PARAM);

//标签后缀
$LABEL_POSTFIX = array('index');
$ENV = $core->ismobile?'mobile':'';

//防止窜标题及SEO
unset($data, $CAT);

$LINKRSS = array(
	'title' => $core->CONFIG['site_name'],
	'url' => $this_system->controller .'/item-rss'
);

$template = 'index';

include template($this_system, $template);

//保存页面缓存
page_cache();