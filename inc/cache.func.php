<?php
defined('PHP168_PATH') or die();

function cache_system_module($module_data_cache = false){
	global $core,$CACHE,$_ALLCACHE;
	//��������ϵͳ,ģ������
	$sm = array();
	
	$URI = '
	URI: {';
	$s_comma = '';
	
	md(CACHE_PATH .'core/modules/', true);
	//����ģ����
	if($CACHE->read('', 'core', 'sm_cache_lock', 'serialize')){
		message('sm_caching_lock');		
	}else{
		$_ALLCACHE = array('sm_offset' => 99);
		$core->CACHE->write('', 'core', 'sm_cache_lock', $_ALLCACHE, 'serialize');
	}
	foreach($core->list_systems(true) as $k => $v){
		$s = &$core->load_system($k);
		md(CACHE_PATH . $k .'/modules/', true);
		$s->set_config(array(
			'table_prefix' => $v['table_prefix']
		));
		
		$sm[$k] = array(
			'name' => $s->name,
			'url' => $s->url,
			'controller' => $s->controller,
			'U_controller' => $s->U_controller,
			'alias' => $v['alias'],
			'class' => $v['class'],
			//ϵͳ��ǰ׺,�����ǰ׺Ϊ��,�Զ����ϵ�ǰ��ǰ׺
			'table_prefix' => empty($v['table_prefix']) ? P8_TABLE_ . $k .'_' : $v['table_prefix'] . $k .'_',
			'controller_class' => $v['controller_class'],
			'installed' => $v['installed'],
			'enabled' => $v['enabled'],
			'modules' => array()
		);
		$URI .= $s_comma ."
		'$s->name': {".
			"'': {".
				"url: '$s->url',".
				"controller: '$s->controller',".
				"U_controller: '$s->U_controller'".
			"},";
		$s_comma = ',';
		
		$m_comma = '';
		
		foreach($s->list_modules(true) as $kk => $vv){
			$m = &$s->load_module($kk);
			md(CACHE_PATH . $k .'/modules/'. $kk, true);
			
			if($module_data_cache && $vv['installed']){
				//�Ƿ�Ҳ����ģ������ݻ���
				$m->set_config(array());
				$m->cache();
			}
			
			$sm[$k]['modules'][$kk] = array(
				'name' => $m->name,
				'url' => $m->url,
				'controller' => $m->controller,
				'U_controller' => $m->U_controller,
				'alias' => $vv['alias'],
				'class' => $vv['class'],
				'controller_class' => $vv['controller_class'],
				'installed' => $vv['installed'],
				'enabled' => $vv['enabled']
			);
			$URI .= $m_comma ."
			'$m->name': {".
				"url: '$m->url',".
				"controller: '$m->controller',".
				"U_controller: '$m->U_controller'".
			"}";
			$m_comma = ',';
			$m = null;
		}
		
		$URI .= "
		}";
		
		//�ͷ��ڴ�
		$core->unload($k);
	}
	$core->systems = $sm;
	
	$URI .= ",
		core: {".
			"'': {".
				"url: '$core->url',".
				"controller: '$core->controller'".
			"},";

	$cm = array();
	//���º���ģ������
	$m_comma = '';
	foreach($core->list_modules(true) as $k => $v){
		$m = &$core->load_module($k);
		md(CACHE_PATH .'core/modules/'. $k, true);
		
		if($module_data_cache && $v['installed']){
			//�Ƿ�Ҳ����ģ������ݻ���
			$m->set_config(array());
			$m->cache();
		}
		
		$cm[$k] = array(
			'name' => $m->name,
			'url' => $m->url,
			'controller' => $m->controller,
			'U_controller' => $m->U_controller,
			'alias' => $v['alias'],
			'class' => $v['class'],
			'controller_class' => $v['controller_class'],
			'installed' => $v['installed'],
			'enabled' => $v['enabled']
		);
		
		$URI .= $m_comma ."
			'$m->name': {".
				"url: '$m->url',".
				"controller: '$m->controller',".
				"U_controller: '$m->U_controller'".
			"}";
			$m_comma = ',';
		$m = null;
	}
	$core->modules = $cm;
	
	$URI .= "
		}
	}";
	
	//���²������
	$ps = array();
	foreach($core->list_plugins(true) as $k => $v){
		
		$p = &$core->load_plugin($k);
		md(CACHE_PATH .'core/plugin/'. $v['name'], true);
		$p->set_config(array());
		
		$ps[$k] = array(
			'alias' => $v['alias'],
			'class' => $v['class'],
			'installed' => $v['installed'],
			'enabled' => $v['enabled']
		);
		
		if($v['installed'] && $v['enabled']){
			//$p->_cache();
		}
	}
	
	//���º��Ļ���
	if($sm && $cm){
		$core->set_config(array('system&module' => $sm, 'modules' => $cm, 'plugins' => $ps));
	}
	//����
	$CACHE->delete('', 'core', 'sm_cache_lock');
	$config = $core->get_config('core', '');
	//JS����
	$jsconfig = "var P8CONFIG = {
	url: '{$config['url']}',
	RESOURCE: '". $core->RESOURCE ."',
	language: '{$config['lang']}',
	controller: '{$core->controller}',
	U_controller: '{$core->U_controller}',
	cookie_prefix: '{$config['cookie']['prefix']}',
	cookie_path: '{$config['cookie']['path']}',
	base_domain: '{$config['base_domain']}',
	mobile_status: ".intval($config['enable_mobile']).",
	mobile_auto_jump: ".intval($config['mobile_auto_jump']).",
	mobile_url: '{$config['murl']}',
	$URI
};";
	
	write_file(PHP168_PATH .'js/config.js', $jsconfig);
	
	rm(CACHE_PATH .'ips.php');
}

function cache_language(){
	global $core, $CACHE;
	
	//�������԰�
	$core->list_language(true);
	if($CACHE->memcache){
		$path = str_replace(PHP168_PATH, '', LANGUAGE_PATH);
		$CACHE->memcache_delete($path . $core->CONFIG['lang'] .'_loaded');
	}
}

function cache_word_filter(){
	global $core;
	
	$query = $core->DB_master->query("SELECT * FROM {$core->TABLE_}filter_word");
	$filter = $comma = '';
	while($arr = $core->DB_master->fetch_array($query)){
		$filter .= $comma . $arr['filter_word'];
		$comma = '|';
	}
	$filter = $filter ? '/('. $filter .')/i' : '';
	
	$core->CACHE->write('', $core->name, 'word_filter', $filter);
}

function cache_template(){
	global $core;
	
	//����ģ�建��
	rm(CACHE_PATH .'template/', true);
	//����ģ��
	$core->list_templates(true);
}

//���²˵�����
function cache_menu(){
	cache_admin_menu();
	cache_member_menu();
	cache_homepage_menu();
	cache_navigation_menu();
}

function cache_admin_menu(){
	global $admin_menu;
	
	require_once PHP168_PATH .'admin/inc/menu.class.php';
	$admin_menu->cache();
}

function cache_member_menu(){
	global $member_menu;
	
	require_once PHP168_PATH .'modules/member/inc/menu.class.php';
	$member_menu->cache();
}

function cache_homepage_menu(){
	global $homepage_menu;
	
	require_once PHP168_PATH .'inc/homepage_menu.class.php';
	$homepage_menu->cache();
}

function cache_navigation_menu(){
	global $navigation_menu;
	
	require_once PHP168_PATH .'admin/inc/navigation_menu.class.php';
	$navigation_menu->cache();
}

function cache_label(){
	global $core;
	
	$LABEL = &$core->load_module('label');
	$LABEL->cache();
	$LABEL->cache_data();
}

function cache_all(){
	
	cache_system_module(true);
	cache_language();
	cache_template();
	cache_word_filter();
	cache_menu();
}

/**
* ���ҳ�滺��
**/
function clear_page_cache(){
	global $core;
	$core->DB_master->query("TRUNCATE TABLE {$core->TABLE_}pagecache");
}