<?php
defined('PHP168_PATH') or die();

/**
* CMS��ҳ
**/

if(
	!empty($this_system->CONFIG['forbidden_dynamic']) &&
	!($IS_ADMIN || $IS_FOUNDER || defined('P8_GENERATE_HTML'))
){
	//��ֹ�鿴��̬ҳ,���ɾ�̬����Ա����
	//message('access_denied');
	header('Location: '. ($core->CONFIG['index_system'] == $SYSTEM ? $core->url : $this_system->url));
	exit;
}

//ҳ�滺�����: ϵͳ��ҳ
$PAGE_CACHE_PARAM['system_index'] = 'cms';
$PAGE_CACHE_PARAM['mobile'] = $core->ismobile;

//ҳ�滺��
$PAGE_CACHE_PARAM['ttl'] = empty($this_system->CONFIG['index_page_cache_ttl']) ? 0 : $this_system->CONFIG['index_page_cache_ttl'];
page_cache($PAGE_CACHE_PARAM);

//��ǩ��׺
$LABEL_POSTFIX = array('index');
$ENV = $core->ismobile?'mobile':'';

//��ֹ�ܱ��⼰SEO
unset($data, $CAT);

$LINKRSS = array(
	'title' => $core->CONFIG['site_name'],
	'url' => $this_system->controller .'/item-rss'
);

$template = 'index';

include template($this_system, $template);

//����ҳ�滺��
page_cache();