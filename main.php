<?php
defined('PHP168_PATH') or die();

if(
	!empty($core->CONFIG['forbidden_dynamic']) &&
	!($IS_ADMIN || $IS_FOUNDER || defined('P8_GENERATE_HTML'))
){
	//��ֹ�鿴��̬ҳ,���ɾ�̬����Ա����
	message('access_denied');
}

$PAGE_CACHE_PARAM['ttl'] = empty($core->CONFIG['index_page_cache_ttl']) ? 0 : $core->CONFIG['index_page_cache_ttl'];
page_cache($PAGE_CACHE_PARAM);

$LABEL_POSTFIX = array('index');

include template($core, 'index');

//����ҳ�滺��
page_cache();