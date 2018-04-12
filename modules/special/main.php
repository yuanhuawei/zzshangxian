<?php
defined('PHP168_PATH') or die();
//页面缓存参数: 系统首页
$PAGE_CACHE_PARAM['system_index'] = 'core/special';

//页面缓存
$PAGE_CACHE_PARAM['ttl'] = empty($this_module->CONFIG['index_page_cache_ttl']) ? 0 : $this_module->CONFIG['index_page_cache_ttl'];
page_cache($PAGE_CACHE_PARAM);

//标签后缀
$LABEL_POSTFIX = array('index');

//SEO
$TITLE = $P8LANG['special']['special'].' - '.$core->CONFIG['site_name'];
$SEO_KEYWORDS = $core->CONFIG['site_key_word'];
$SEO_DESCRIPTION = $core->CONFIG['site_description'];
include template($this_module, 'index');

page_cache();