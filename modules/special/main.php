<?php
defined('PHP168_PATH') or die();
//ҳ�滺�����: ϵͳ��ҳ
$PAGE_CACHE_PARAM['system_index'] = 'core/special';

//ҳ�滺��
$PAGE_CACHE_PARAM['ttl'] = empty($this_module->CONFIG['index_page_cache_ttl']) ? 0 : $this_module->CONFIG['index_page_cache_ttl'];
page_cache($PAGE_CACHE_PARAM);

//��ǩ��׺
$LABEL_POSTFIX = array('index');

//SEO
$TITLE = $P8LANG['special']['special'].' - '.$core->CONFIG['site_name'];
$SEO_KEYWORDS = $core->CONFIG['site_key_word'];
$SEO_DESCRIPTION = $core->CONFIG['site_description'];
include template($this_module, 'index');

page_cache();