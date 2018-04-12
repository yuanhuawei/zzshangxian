<?php
defined('PHP168_PATH') or die();

  //##################/
 //#	������		#/
//##################/
class P8_Core{

var $name,				//����
	$CONFIG,			//����
	$_CONFIG,			//����
	$CACHE,				//������������
	$systems,			//���е�ϵͳ
	$_loaded_systems,	//��װ�ص�ϵͳ
	$modules,			//���е�ģ��
	$_loaded_modules,	//�����ص�ģ��
	$plugins,			//���еĲ��
	$_loaded_plugins,	//�����صĲ��
	$credits,			//��������
	$roles,				//��ɫ
	$role_groups,		//��ɫ��
	$_role_data,		//��ɫ����
	$path,				//���ĵľ���·��
	$url,				//���ĵ�URL
	$murl,				//���ĵ��ƶ�URL
	$controller,		//ǰ̨���
	$mobile_controller,	//ǰ̨�ƶ����
	$admin_controller,	//��̨���
	$U_controller,		//��Ա�������
	$wap_controller,	//wap���
	$DB_master,			//�����ݿ����
	$DB_slave,			//�����ݿ����
	$ROLE,				//��ɫ
	$type,				//��������
	$TABLE_,			//���ı���ǰ׺,��P8_TABLE_������ͬ,�������ú������ݿ����ڵ�ǰ׺, php168.p8_,Ϊ��̨PHP����������һ���������ݿ�Ԥ���ӿ�
	$member_table,		//���Ļ�Ա��
	$attachment_table,	//������
	$attachment_url,	//������
	$RESOURCE,
	$clustered,			//�Ƿ�Ⱥ
	
	$ismobile,			//�Ƿ��ƶ��豸
	$MOBILE;			//�ƶ��豸����

function __construct(){
	
	$this->path = PHP168_PATH;
	$this->name = $this->type = 'core';
	
	$this->systems = $this->modules = $this->_loaded_systems = $this->_loaded_modules = array();
	//error_reporting(E_ALL);
	//��������

	$config = include CACHE_PATH .'config.php';
	$memcahce_config = is_file(CACHE_PATH.'memcahce_config.php') ? include CACHE_PATH .'memcahce_config.php' : array();
	if($memcahce_config){
		$config['memcache'] = $memcahce_config;
	}
	$this->_CONFIG = $this->CONFIG = $config;
	unset($config);
	
	global $CACHE;
	$CACHE = new P8_Cache($this);
	$this->CACHE = &$CACHE;
	
	$_config = $this->CACHE->read('', 'core', '');
	$_config = is_array($_config)?$_config:array();
	
	$this->CONFIG = array_merge($_config, $this->CONFIG);
	unset($_config);
	
	$this->TABLE_ = empty($this->CONFIG['core_table_prefix']) ? $this->CONFIG['table_prefix'] : $this->CONFIG['core_table_prefix'];
	$this->attachment_table = $this->TABLE_ .'attachment';
	$this->member_table = $this->TABLE_ .'member';
	
	//���ʵ�ַ
	$this->url = &$this->CONFIG['url'];
	$this->RESOURCE = empty($this->CONFIG['resource_url']) ? $this->url : $this->CONFIG['resource_url'];
	
	//�Ƿ���rewrite��������index.php
	$this->controller = $this->url .(empty($this->CONFIG['url_rewrite_enabled']) ? '/index.php' : '');
	
	$this->admin_controller = empty($this->CONFIG['admin_controller']) ? rtrim($this->url,'/') .'/admin.php' : rtrim($this->url,'/'). '/' . $this->CONFIG['admin_controller'];
	
	$this->U_controller = $this->CONFIG['url'] .'/u.php';
	
	$this->systems = &$this->CONFIG['system&module'];
	$this->modules = &$this->CONFIG['modules'];
	$this->plugins = &$this->CONFIG['plugins'];
	$this->credits = &$this->CONFIG['credits'];
	$this->clustered = !empty($this->modules['cluster']['installed']) && !empty($this->modules['cluster']['enabled']);
	$this->attachment_url = $this->url .'/'. $this->CONFIG['attachment']['path'];
	
	//��ʼ�������ݿ�
	$this->DB_connect();
	$this->DB_connect('slave');
	
	//��ʼ���ƶ�
	$this->int_mobile();
	
}

function P8_Core(){
	$this->__construct();
}


/**
* ����ϵͳ
* @param string $name ϵͳ����
* @return object ϵͳ����
**/
function &load_system($name){
	$name = strtolower($name);
	//ÿ��ϵͳֻ����װ��һ��
	if(isset($this->_loaded_systems[$name])) return $this->_loaded_systems[$name];
	
	if(!isset($this->systems[$name])){
		echo 'Error: The system '. $name .' you load doesn\'t exist<br />';
		foreach(debug_backtrace() as $v){
			echo "$v[file]: $v[line]<br />\r\n";
		}
		exit;
	}
	
	require_once $this->path . $name .'/system.php';
	$this->_loaded_systems[$name] = &new $this->systems[$name]['class']($this, $name);
	return $this->_loaded_systems[$name];
}

/**
* �г�����ϵͳ
* @param boolean $refresh �Ƿ������г�, Ĭ�϶�ȡ����
* @return array ����ϵͳ������
* ����������л���
**/
function list_systems($refresh = false){
	
	if($refresh){
		return include PHP168_PATH .'inc/call/refresh_systems.call.php';
	}else{
		
		return empty($this->systems) ? $this->systems = &$this->CONFIG['system&module'] : $this->systems;
	}
}

/**
* ����ϵͳ��ģ��
* @param string $name ģ������
* @return object ģ�����
**/
function &load_module($name){
	$name = strtolower($name);
	if(isset($this->_loaded_modules[$name])) return $this->_loaded_modules[$name];
	
	if(!isset($this->modules[$name])){
		echo 'Error: The module '. $name .' you load doesn\'t exist<br />';
		foreach(debug_backtrace() as $v){
			echo "$v[file]: $v[line]<br />\r\n";
		}
		exit;
	}
	
	require_once $this->path .'modules/'. $name .'/module.php';
	$this->_loaded_modules[$name] = &new $this->modules[$name]['class']($this, $name);
	return $this->_loaded_modules[$name];
}

/**
* ����ģ����б�
* @param boolean $refresh �Ƿ������г�, Ĭ�϶�ȡ����
* @return array ��������ģ�������
**/
function list_modules($refresh = false){
	
	if($refresh){
		return include PHP168_PATH .'inc/call/refresh_core_modules.call.php';
	}else{

		return empty($this->modules) ? $this->modules = &$this->CONFIG['modules'] : $this->modules;
	}

}

/**
* Ӧ�ÿ��Ʋ�
* @param object $obj ����,ϵͳ,ģ�����
* @return object ���Ʋ����
**/
function &controller(&$obj){
	switch($obj->type){
	
	case 'system':
		$name = empty($obj->core->systems[$obj->name]['controller_class']) ? '' : $obj->core->systems[$obj->name]['controller_class'];
		require_once $obj->path .'controller.php';
	break;
	
	case 'module':
		$name = empty($obj->system->modules[$obj->name]['controller_class']) ? '' : $obj->system->modules[$obj->name]['controller_class'];
		require_once $obj->path .'controller.php';
	break;
	
	case 'core':
		$name = 'P8_Controller';
	break;
	
	}

	if(empty($name)){
		$ret = false;
		return $ret;
	}

	$controller = &new $name($obj);
	return $controller;
}

function &load_plugin($name){
	$name = strtolower($name);
	if(isset($this->_loaded_plugins[$name])) return $this->_loaded_plugins[$name];
	
	if(!isset($this->plugins[$name])) return null;
	
	require_once PHP168_PATH .'inc/plugin.class.php';
	require_once PHP168_PATH .'plugin/'. $name .'/plugin.php';
	$this->_loaded_plugins[$name] = &new $this->plugins[$name]['class']($this, $name);
	return $this->_loaded_plugins[$name];
}

function list_plugins($refresh = false){
	return include PHP168_PATH .'inc/call/refresh_plugins.call.php';
}

/**
* ���԰��б�
* @param bool $refresh �Ƿ������г�
**/
function list_language($refresh = false){
	//if(isset($this->CONFIG['language'])) return $this->CONFIG['language'];
	return include PHP168_PATH .'inc/call/list_language.call.php';
}

/**
* ģ���б�
* @param bool $refresh �Ƿ������г�
**/
function list_templates($refresh = false){
	return include PHP168_PATH .'inc/call/list_templates.call.php';
}

/**
* ��ȡ����
* @param string $system ϵͳ����
* @param string $module ģ������
* @return array ����
**/
function get_config($system, $module){
	$query = $this->DB_master->query("SELECT type, k, v FROM {$this->TABLE_}config WHERE system = '$system' AND module = '$module'");
	$config = array();
	while($v = $this->DB_master->fetch_array($query)){
		$config[$v['k']] = $v['type'] == 'serialize' ? mb_unserialize($v['v']) : $v['v'];
	}
	return $config;
}

/**
* д����
* ���ñ��ʽ
* system(ϵͳ)	module(ģ��)	type(��������)		key(��ֵ)		value(ֵ)
*
* core							string				lang			zh-cn			//������������
* b				business_sell	serialize			ĳ������		���л�������	//������ϵͳĳ����������
* @param array $datas ��ʽarray('key' => 'value'), Ҫд�������,ֻд�ֲ�����
* @param array $protect_fields �����ֶ�,����д�����ݿ�
* @param boolean �Ƿ�д�ɹ���
**/
function set_config(
	$datas,
	$protect_fields = array(),
	$ignore_fields = array()
){
	$protect_fields = array_merge(
		$protect_fields,
		array(
			//mysql��ѡ��������
			'mysql_connect_types' => 1,
			//�����ݿ�����
			'DB_master' => 1,
			//��ѡ�ı��뺯��
			'encode_conv_functions' => 1,
			//��ǰ׺
			'table_prefix' => 1
		)
	);
	
	$ignore_fields = array_merge(
		$ignore_fields,
		array(
			'admin_actions' => 1,
			'actions' => 1
		)
	);
	
	$this->CONFIG = $this->_set_config(
		$this->name,
		'',
		$this->path,
		'',
		'core',
		$datas,
		$protect_fields,
		$ignore_fields
	);
	
	/*
	*/
	
	return true;
}

/**
* ͳһд����
* @param string $system ϵͳ����
* @param string $module ģ������
* @param string $path ϵͳ/ģ��ľ���·��
* @param string $cache_path ϵͳ/ģ��Ļ���·��
* @param string $cache_name ϵͳ/ģ��Ļ�������
* @param mix $datas ϵͳ/ģ��Ļ�������
* @param array $protect_fields ϵͳ/ģ��ı����ֶ�,��д�����ݿ⵫��д������
* @param array $ignore_fields ϵͳ/ģ��Ĳ���д�����ݿ�Ҳ���ᱻ�뻺����ֶ�
**/
function _set_config(
	$system,
	$module,
	$path,
	$cache_path,
	$cache_name,
	$datas,
	$protect_fields = array(),	//�����ֶ�,����д�����ݿ�Ҳ��������д������,�������ֶ��޸�
	$ignore_fields = array()	//�����ֶ�,����д�����ݿ�Ҳ����д������
){
	global $_syn_configs;
	$_syn_configs[$system][$module] = 1;
	//ͬ������
	
	$info = include $path .'#.php';
	
	$query = $this->DB_master->query("SELECT type, k, v FROM {$this->TABLE_}config WHERE system = '$system' AND module = '$module'");
	$config = array();
	while($v = $this->DB_master->fetch_array($query)){
		$config[$v['k']] = $v['type'] == 'serialize' ? mb_unserialize($v['v']) : $v['v'];
		unset($info[$v['k']]);		//������ݿ����ֵ�Ѿ�����,ɾ��#.php��ֵ
	}
	
	//ȥ��ħ������
	//$datas = p8_stripslashes2($datas);
	//���������
	$datas = array_merge($info, $datas);	//$datas����$info��ֵ
	unset($info);
	
	//���ڲ������ݿ�
	$db_datas = array();
	foreach($datas as $k => $v){
		if(isset($protect_fields[$k])){
			continue;
		}
		if(isset($ignore_fields[$k])){
			unset($datas[$k]);
			continue;
		}
		
		//����������
		$config[$k] = $v;
		$_k = $this->DB_master->escape_string($k);	//���й���
		$type = 'string';
		
		$_v = $v;
		if(is_array($v) || is_object($v)){
			$_v = serialize($v);//�������������ͽ������л�
			$type = 'serialize';
		}
		$_v = $this->DB_master->escape_string($_v);	//���й���
		
		$db_datas[] = array($system, $module, $type, $_k, $_v);
	}
	
	//�����滻
	$this->DB_master->insert(
		$this->TABLE_ .'config',
		$db_datas,
		array(
			'multiple' => array('system' ,'module' ,'type' ,'k' ,'v'),
			'replace' => true
		)
	);
	
	$datas = array_merge($datas, $config);	//$config ���� $datas��ֵ
	unset($config, $db_datas);
	
	//д����
	
	if($system == 'core' && $cache_name == 'core'){
		if(isset($datas['system&module']) && !empty($datas['system&module'])) $this->CACHE->write($cache_path, $cache_name, '', $datas);
	}else{
		$this->CACHE->write($cache_path, $cache_name, '', $datas);
	}
	if($system == 'core' && $module == ''){
		$this->_CONFIG['memcache'] = $datas['memcache'];

		write_file(CACHE_PATH .'memcahce_config.php', "<?php\r\nreturn ". var_export($this->_CONFIG['memcache'], true) .';');	
	}
	
	return $datas;
}

/**
* �������ݿ�
* @param string $type ��������,masterΪ�����ݿ�,slaveΪ�����ݿ�,ʵ�ֶ�д����
* @return boolean
**/
function DB_connect($type = 'master'){
	$mysql_connect_type = isset($this->CONFIG['mysql_connect_type'])?$this->CONFIG['mysql_connect_type']: 'mysql';
	$mysql_connect_charset = isset($this->CONFIG['mysql_charset'])?$this->CONFIG['mysql_charset']: 'gbk';
	$mysql_connect_port = isset($this->CONFIG['mysql_connect_port'])?$this->CONFIG['mysql_connect_port']: 3306;
	require_once PHP168_PATH .'inc/'. $mysql_connect_type .'.class.php';
	
	//���Ӷ����ݿ�
	if($type == 'slave'){
		//��ʼ�������˳�
		if(is_object($this->DB_slave)) return true;
		
		if(!isset($this->CONFIG['DB_slave']) || ($count = count($this->CONFIG['DB_slave'])) == 0){
			$this->DB_connect('master');
			$this->DB_slave = &$this->DB_master;
			return true;
		}
		
		//���ֻ��һ����,���Ҵӵ����õ�����������,��Ѵ���Ϊ������
		if($count == 1 && $this->CONFIG['DB_slave'][0] == $this->CONFIG['DB_master']){
			$this->DB_slave = &$this->DB_master;
		}else{//�ж����
			//������һ��������
			$k = array_rand($this->CONFIG['DB_slave']);
			$mysql_connect_type = isset($this->CONFIG['mysql_connect_types'][$mysql_connect_type])?$this->CONFIG['mysql_connect_types'][$mysql_connect_type]:'P8_mysql';
			$this->DB_slave = new $mysql_connect_type(
				$this->CONFIG['DB_slave'][$k]['host'],
				$this->CONFIG['DB_slave'][$k]['user'],
				$this->CONFIG['DB_slave'][$k]['password'],
				$this->CONFIG['DB_slave'][$k]['db'],
				$mysql_connect_charset,
				$this->CONFIG['DB_slave'][$k]['port'],
				$this->CONFIG['DB_slave'][$k]['pconnect']
			);
		}
		
	}else{
		//д
		if(is_object($this->DB_master)) return true;
		
		if(empty($this->CONFIG['DB_master'])) die('û���������ݿ�');
		$mysql_connect_type = isset($this->CONFIG['mysql_connect_types'][$mysql_connect_type])?$this->CONFIG['mysql_connect_types'][$mysql_connect_type]:'P8_mysql';
		$this->DB_master = new $mysql_connect_type(
			$this->CONFIG['DB_master']['host'],
			$this->CONFIG['DB_master']['user'],
			$this->CONFIG['DB_master']['password'],
			$this->CONFIG['DB_master']['db'],
			$mysql_connect_charset,
			$mysql_connect_port,
			$this->CONFIG['DB_master']['pconnect']
		);
	}
}

/**
* ���URL·��
**/
function get_router(){
	list($uri, ) = explode('?', $_SERVER['_REQUEST_URI'], 2);
	global $__FILE__;
	$self = basename($__FILE__);
	substr($uri, -1) == '/' && $uri .= $self;
	$uri = substr(preg_replace('|^/.*'. $self .'|U', '', $uri), 1);
	
	if(empty($uri)) return array();
	
	//ֻ�ָ�1��/
	$s = explode('/', $uri, 2);
	
	return $s;
}

/**
* (��ҳ)�б�
* @param object $select select����
* @param int $page ҳ��
* @param int $page_size ÿҳ������
* @param int $count ���ҵļ�¼����
* @return array �����
**/
function list_item(&$select, $options = array()){
	$options['page'] = empty($options['page']) ? 0 : intval($options['page']);
	$options['count'] = empty($options['count']) ? 0 : intval($options['count']);
	$options['page_size'] = empty($options['page_size']) ? 0 : intval($options['page_size']);
	$options['sphinx'] = empty($options['sphinx']) ? array() : $options['sphinx'];
	$options['ms'] = empty($options['ms']) ? 'slave' : $options['ms'];
	$options['db_obj'] = empty($options['db_obj']) ? null : $options['db_obj'];
	$options['key_for_return'] = empty($options['key_for_return']) ? '' : $options['key_for_return'];
	$options['return'] = empty($options['return']) ? '' : $options['return'];
	
	//�Ƿ���Ҫ��ҳ,���page = 0,���÷�ҳ
	$list_page = $options['page'] && $options['page_size'];
	
	if($options['db_obj']){
		$db = &$options['db_obj'];
	}else if($options['ms'] == 'master'){
		$db = &$this->DB_master;
	}else{
		$db = &$this->DB_slave;
	}
	
	//���������sphinx����
	if(!empty($options['sphinx']['enabled'])){
		if($list_page){
			//�����Ҫ��ҳ
			$select->limit(($options['page'] -1) * $options['page_size'], $options['page_size']);
		}else if($options['page_size']){
			//����ҳ����������
			$select->limit(0, $options['page_size']);
		}
		
		$result = p8_sphinx_fetch($select, $options['sphinx']);
		
		$datas = $ids = array();
		if(empty($result['matches'])) return $datas;
		
		//�����ƥ�����
		foreach($result['matches'] as $v){
			$datas[$v['id']] = array('id' => $v['id']);
			$ids[] = $v['id'];
		}//ȡ��������
		
		//�����������
		$select->sphinx_clear();
		
		//ֻȡ��һ��from���ֵ�ID��������,$select->from('first_from AS i', 'i.*'), ��i.id�ᱻʹ��
		$alias = array_shift(array_keys($select->_from));
		$select->in($alias .'.id', $ids);
		//����дprimary IN ($ids)��where������ȡ����
		$query = $this->select($select, array('ms' => $options['ms'], 'return' => 'query', 'db_obj' => &$options['db_obj']));
		
		//�����ص�ID˳�����, 3, 1, 2����˳����SQL��ѯ��᷵��1,2,3
		while($arr = $db->fetch_array($query)){
			$datas[$arr['id']] = $arr;
		}
		
		if($list_page){
			//�ܹ��ҵ���������¼
			$options['count'] = $result['total_found'];
			//��ҳ��
			$pages = ceil($options['count'] / $options['page_size']);
		}
		
		//�������±�Ϊ0��ͷ������
		return array_values($datas);
		
	}else{
		//Ĭ�ϵ����ݿ��ѯ
		if($list_page){
			//�����Ҫ��ҳ
			
			if($options['count'] <= 0){
				$count = $db->fetch_one($select->build_count_sql());
				
				$options['count'] = $count['num'];
			}
			
			//û������ֱ�ӷ��ؿ�����
			if($options['count'] == 0) return array();
			
			$pages = ceil($options['count'] / $options['page_size']);
			$options['page'] = min($pages, $options['page']);
			$select->limit(($options['page'] -1) * $options['page_size'], $options['page_size']);
		}else if($options['page_size']){
			//����ҳ����������
			$select->limit(0, $options['page_size']);
		}

		return $this->select(
			$select, 
			array(
				'ms' => $options['ms'],
				'return' => $options['return'],
				'key_for_return' => $options['key_for_return'],
				'db_obj' => &$options['db_obj']
			)
		);
	}
}

/**
* ������
* @param object $select select����SQL�Ķ���
**/
function select(&$select, $option = array()){
	
	$option['single'] = empty($option['single']) ? false : true;
	$option['ms'] = isset($option['single']) && $option['ms'] = 'master' ? 'master' : 'slave';
	//�Լ�ֵ����
	$option['key_for_return'] = empty($option['key_for_return']) ? '' : $option['key_for_return'];
	//����query������
	$option['return'] = isset($option['return']) && $option['return'] == 'query' ? 'query' : 'array';
	$option['db_obj'] = empty($option['db_obj']) ? null : $option['db_obj'];
	
	if($option['db_obj']){
		$db = &$option['db_obj'];
	}else if($option['ms'] == 'master'){
		$db = &$this->DB_master;
	}else{
		$db = &$this->DB_slave;
	}
	
	if($option['single']){
		
		return $db->fetch_one($select->build_sql());
		
	}else if($option['key_for_return']){
		
		$query = $db->query($select->build_sql());
		$ret = array();
		while($arr = $db->fetch_array($query)){
			$ret[$option['key_for_return']] = $arr;
		}
		return $ret;
		
	}else{
		return $option['return'] == 'query' ? $db->query($select->build_sql()) : $db->fetch_all($select->build_sql());
	}
	
}

/**
* ���»�Ա�Ļ���
* @param int $uid ��Աid
* @param array $credits ����ID => ����
* @param bool $add �Ƿ�����+,��credit +1,���������ѻ�������Ϊcredits�����ֵ, credit = 1
**/
function update_credit($uid, $credits, $add = true){
	$uid = (array)$uid;
	if(empty($uid) || empty($credits)) return false;
	
	/*
	if(!empty($this->CONFIG['integration']['type'])){
		
	}
	*/
	
	$data = $log = array();
	foreach($credits as $id => $v){
		if($add){
			$data['credit_'. $id] = 'credit_'. $id .'+'. $v;
			foreach($uid as $u){
				$log[] = array(
					'uid' => $u,
					'credit_id' => $id,
					'credit' => $v,
					'timestamp' => P8_TIME
				);
			}
		}else{
			$data['credit_'. $id] = $v;
		}
	}
	
	if($add){
		return $this->DB_master->update(
			$this->TABLE_ .'credit_member',
			$data,
			'id IN ('. implode(',', $uid) .')',
			false
		);
		
		$this->DB_master->insert(
			$this->TABLE_ .'credit_log',
			$log,
			array(
				'multiple' => array('uid', 'credit_id', 'credit', 'timestamp')
			)
		);
	}else{
		return $this->DB_master->update(
			$this->TABLE_ .'credit_member',
			$data,
			'id IN ('. implode(',', $uid) .')'
		);
	}
}

/**
* ��û�Ա�Ļ���
**/
function get_credit($uid){
	$tmp = $this->DB_master->fetch_one("SELECT * FROM {$this->TABLE_}credit_member WHERE id = '$uid'");
	if(empty($tmp)) return array();
	
	unset($tmp['id']);
	$ret = array();
	foreach($tmp as $k => $v){
		$ret[substr($k, 7)] = $v;
	}
	return $ret;
}

/**
* @param int $uid �û�ID
* @param int $source_id Դ����ID
* @param int $target_id Ŀ�����ID
* @param int|float $amount Ҫ�һ�Ŀ����ֵ�����
**/
function exchange_credit($uid, $source_id, $target_id, $amount){
	//������ʲ�����ֱ�ӷ���
	if(empty($this->credits[$source_id]['roe'][$target_id])) return false;
	
	$need = ceil($amount / $this->credits[$source_id]['roe'][$target_id]);
	
	$credits = $this->get_credit($uid);
	//���ֲ���
	if($credits[$source_id] < $need) return false;
	
	$data = array($target_id => $amount, $source_id => -$need);
	
	return $this->update_credit($uid, $data);
}

/**
* ��ȡ����ģ��Ļ���
**/
function get_cache($type){
	switch($type){
	
	//��ɫ����
	case 'role':
		if(empty($this->roles)){
			global $CACHE;
			$this->_role_data = $CACHE->read('core/modules', 'role', 'roles', 'serialize');
			
			$this->roles = &$this->_role_data['roles'];
		}
		
		if(func_num_args() > 1){
			$param = func_get_args(); array_shift($param);
			$type = array_shift($param);
			$ref = &$this->_role_data;
			
			switch($type){
				case 'role_group': $ref = $ref['group_roles']; break;
				case 'system': $ref = $ref['system_roles']; break;
				case 'type': $ref = $ref['type_roles']; break;
				case 'all': $ref = $ref['roles']; break;
			}
			if($first = array_shift($param)){
				$ref = $ref[$first];
			}
			
			foreach($param as $v){
				$ref = $ref[$v];
			}
			
			return $ref;
		}
	break;
	
	//��ɫ�黺��
	case 'role_group':
		if(empty($this->role_groups)){
			global $CACHE;
			$this->role_groups = $CACHE->read('core/modules', 'role', 'groups');
		}
	break;
	
	//Ȩ�޻���
	case 'acl':
		$param = func_get_args();
		
		$role = isset($param[1]) ? 'role_'. $param[1] : 0;
		$system = isset($param[2]) ? $param[2] : '';
		$module = isset($param[3]) ? $param[3] : '';
		$postfix = isset($param[4]) ? $param[4] : '';
		
		$key = $system;
		$key .= $module ? '/modules/'. $module : '';
		$role .= $postfix ? '#'. $postfix : '';
		
		return $this->CACHE->read($key, 'acl', $role .'@'. $this->CONFIG['last_acl_cache']);
		
	break;
	
	}
	
}

/**
* ע��ϵͳ��ģ��
**/
function unload($system, $module = ''){
	if($module){
		if($system == 'core'){
			$this->_loaded_modules[$module] = null;
			unset($this->_loaded_modules[$module]);
		}else{
			$this->_loaded_systems[$system]->_loaded_modules[$module] = null;
			unset($this->_loaded_systems[$system]->_loaded_modules[$module]);
		}
	}else{
		foreach($this->_loaded_systems[$system]->_loaded_modules as $mod => $v){
			$this->_loaded_systems[$system]->_loaded_modules[$mod] = null;
			unset($this->_loaded_systems[$system]->_loaded_modules[$mod]);
		}
		$this->_loaded_systems[$system] = null;
		unset($this->_loaded_systems[$system]);
	}
}

/**
* ����
**/
function &integrate(){
	static $inte;
	
	if($inte !== null) return $inte;
	
	if(!empty($this->CONFIG['integration']['type'])){
		require PHP168_PATH .'inc/integrate/'. $this->CONFIG['integration']['type'] .'.php';
		
		$class = 'P8_Integrate_'. $this->CONFIG['integration']['type'];
		
		$inte = new $class($this);
		
		return $inte;
	}
	
	$inte = false;
	return $inte;
}

function load_acl($system, $module = '', $role_id = 0, $postfix = ''){
	static $acl;
	
	if(!isset($acl[$system][$module][$role_id][$postfix])){
		$path = $module ? $system .'/modules/'. $module : $system;
		$acl[$system][$module][$role_id][$postfix] = 
			$this->CACHE->read($path, 'acl', 'role_'. $role_id .($postfix ? '#'. $postfix : '') .'@'. $this->CONFIG['last_acl_cache']);
	}
	
	return $acl[$system][$module][$role_id][$postfix];
}

function int_mobile(){
    if(isset($this->CONFIG['enable_mobile']) && !$this->CONFIG['enable_mobile']){
        $this->ismobile = 0;
    }else{
    	$this->ismobile = defined('ISMOBILE')?ISMOBILE:false;
    }
	$this->murl = empty($this->CONFIG['murl'])? $this->CONFIG['url'].'/m' : $this->CONFIG['murl'];
	$this->mobile_controller = $this->murl .(empty($this->CONFIG['url_rewrite_enabled']) ? '/index.php' : '');
}

}





































  //##################/
 //#	ϵͳ�̳���	#/
//##################/
class P8_System{

var $CONFIG,			//����
	$_loaded_modules,	//�����ص�ģ��
	$modules,			//������ģ��
	$path,				//ϵͳ�ľ���·��
	$name,				//ϵͳ����
	$url,				//ϵͳ��URL
	$murl,				//ϵͳ��URL
	$controller,		//ϵͳ���
	$mobile_controller,		//ϵͳ���
	$admin_controller,
	$U_controller,
	$core,				//���ú���
	$ROLE,
	$table,
	$TABLE_,
	$member_table,		//ϵͳ��Ա��
	$attachment_table,	//������
	$type,
	$DB_master,
	$DB_slave;

function __construct($name){
	
	$this->path = PHP168_PATH . $name . '/';
	$this->name = $name;
	$this->type = 'system';
	
	$this->modules = array();
	
	//��ȡģ���б�
	$this->list_modules();
	
	//����ϵͳ����
	$this->CONFIG = $this->core->CACHE->read('', $this->name);
	
	if(!empty($this->CONFIG['domain'])){
		$this->controller = $this->CONFIG['domain'] .(empty($this->core->CONFIG['url_rewrite_enabled']) ? '/index.php' : '');
		$this->U_controller = $this->CONFIG['domain'] .'/u.php';
		$this->url = $this->CONFIG['domain'];
	}else{
		$this->controller = $this->core->controller .'/'. $this->name;
		$this->U_controller = $this->core->U_controller .'/'. $this->name;
		$this->url = $this->core->url .'/'. $this->name;
		$this->mobile_controller = $this->core->mobile_controller .'/'. $this->name;
		$this->murl = $this->core->murl .'/'. $this->name;
	}
	
	$this->admin_controller = $this->core->admin_controller .'/'. $this->name;
	
	$this->DB_master = &$this->core->DB_master;
	$this->DB_slave = &$this->core->DB_slave;
	
	$this->TABLE_ = (empty($this->CONFIG['table_prefix']) ? P8_TABLE_ : $this->CONFIG['table_prefix']) . $this->name .'_';
	$this->member_table = $this->TABLE_ .'member';
	$this->attachment_table = $this->TABLE_ .'attachment';
	
	if($this->core->systems[$this->name]['installed'])
		$this->get_role();
}

/**
* ���캯��
* @param string $name ϵͳ����
**/
function P8_System($name){
	$this->__construct($name);
}

/**
* ȡ�õ�ǰ�û��ڵ�ǰϵͳ�Ľ�ɫ
**/
function get_role(){
	
	if($this->ROLE) return true;
	
	global $UID, $USERNAME, $_P8SESSION;
	
	if($UID){
		$name = $this->name;
		if(!empty($_P8SESSION['role@system'][$name])){
			//�Ѿ����ù���
			$this->ROLE = $_P8SESSION['role@system'][$name];
			return true;
		}
		
		$member = $this->DB_master->fetch_one("SELECT * FROM $this->member_table WHERE id = '$UID'");
		
		if(empty($member)){
			//�����ϵͳ�Ļ�Աû�м���,�����ø�Ĭ�ϵĻ�ԱȨ��
			$role_id = empty($this->core->CONFIG['use_core_roles_only']) ? $this->core->CONFIG['member_role'] : $this->core->ROLE;
			$this->DB_master->insert(
				$this->member_table,
				array(
					'id' => $UID,
					'username' => $USERNAME,
					'role_id' => $role_id
				)
			);
			
			$member = $this->DB_master->fetch_one("SELECT * FROM $this->member_table WHERE id = '$UID'");
			
			$this->ROLE = $_P8SESSION['role@system'][$this->name] = $role_id;
		}else{
			//��ϵͳ�Ľ�ɫ
			$this->ROLE = $_P8SESSION['role@system'][$this->name] = $member['role_id'];
		}
		
		//unset($member['id'], $member['username'], $member['role_id']);
		
		//$_P8SESSION[$this->name .'_member_info'] = $member;
	}else{
		//û�е�¼�ع鵽��ϵͳ���οͽ�ɫ
		//if(empty($this->CONFIG['guest_role'])) return false;
		
		$role_id = $this->core->CONFIG['guest_role'];
		$this->ROLE = $role_id;
		$_P8SESSION['role@system'][$this->name] = $role_id;
	}
}

function set_config(
	$datas,
	$protect_fields = array(),
	$ignore_fields = array()
){
	
	/* //�����ϵͳû����װ�Ͳ�Ҫд�����˺�������
	if(empty($this->core->systems[$this->name]['installed']))
		return false; */
	
	$protect_fields = array_merge(
		$protect_fields,
		array(
		)
	);
	
	$ignore_fields = array_merge(
		$ignore_fields,
		array(
			'alias' => 1,
			'class' => 1,
			'controller_class' => 1,
			'admin_actions' => 1,
			'actions' => 1,
			'credit_rule_actions' => 1
		)
	);
	
	$this->CONFIG = $this->core->_set_config(
		$this->name,
		'',
		$this->path,
		'',
		$this->name,
		$datas,
		$protect_fields,
		$ignore_fields
	);
	
	return true;
}

//-------------------ģ�麯��------------------------
/**
* ����ϵͳ��ģ��
* @param string $name ģ������
* @return boolean
**/
function &load_module($name){
	$name = strtolower($name);
	if(isset($this->_loaded_modules[$name])) return $this->_loaded_modules[$name];
	
	if(!isset($this->modules[$name])){
		echo 'Error: The module '. $name .' you load doesn\'t exist<br />';
		foreach(debug_backtrace() as $v){
			echo "$v[file]: $v[line]\r\n<br />";
		}
		exit;
	}
	
	require_once $this->path .'/modules/'. $name .'/module.php';
	$this->_loaded_modules[$name] = &new $this->modules[$name]['class']($this, $name);
	return $this->_loaded_modules[$name];
}

/**
* ϵͳģ����б�
* @param boolean $refresh �Ƿ������г�, Ĭ�϶�ȡ����
* @return array ϵͳ����ģ�������
**/
function list_modules($refresh = false){
	
	if($refresh){
		return include PHP168_PATH .'inc/call/refresh_system_modules.call.php';
	}else{
		
		return empty($this->modules) ? $this->modules = &$this->core->CONFIG['system&module'][$this->name]['modules'] : $this->modules;
	}

}


}































  //##################/
 //#	ģ��̳���	#/
//##################/
class P8_Module{


var $name;				//ģ������
var $path;				//ģ��ľ���·��
var $CONFIG;			//����
var $url;				//URL
var $murl;				//URL
var $controller;		//ģ�����
var $admin_controller;
var $U_controller;
var $mobile_controller;
var $system;			//��ϵͳ���������,����ֱ�ӵ�������ϵͳ�ķ���
var $core;				//��������
var $configurable = true;//�Ƿ������,�̳�ʱ����������Ϊfalse,����ʱ���������
var $TABLE_;			//����ǰ׺
var $table;
var $type;				//��������
var $DB_master;
var $DB_slave;

function __construct($name){
	
	$this->path = $this->system->path .'modules/'. $name .'/';
	$this->name = $name;
	$this->type = 'module';
	
	//����,���ģ�������,��������
	if($this->system->type == 'core'){
		$this->core = &$this->system;
	}else{
		$this->core = &$this->system->core;
	}
	
	if($this->configurable){
		$this->CONFIG = $this->core->CACHE->read($this->system->name .'/modules/', $this->name);
	}
	
	if(!empty($this->CONFIG['domain'])){
		
		$this->controller = $this->CONFIG['domain'] .(empty($this->core->CONFIG['url_rewrite_enabled']) ? '/index.php/' : '/');
		$this->U_controller = $this->CONFIG['domain'] .'/u.php/';
		$this->url = $this->CONFIG['domain'];
		
	}else{
		if($this->system->type == 'core'){
			$this->controller = $this->core->controller .'/'. $name;
			$this->U_controller = $this->core->U_controller .'/'. $name;
		}else{
			$this->controller = $this->system->controller .'/'. $name;
			$this->U_controller = $this->system->U_controller .'/'. $name;
		}
		
		$this->url = $this->system->url .'/modules/'. $this->name;
		
		$this->mobile_controller = $this->system->mobile_controller .'/'. $name;
		$this->murl = $this->system->murl .'/modules/'. $this->name;
	}
	$this->admin_controller = $this->system->admin_controller .'/'. $name;
	
	$this->DB_master = &$this->core->DB_master;
	$this->DB_slave = &$this->core->DB_slave;
	
	$this->TABLE_ = $this->system->TABLE_ . $this->name .'_';
}

/**
* ���캯��
* @param string $name ϵͳ��ģ������
**/
function P8_Module($name){
	$this->__construct($name);
}

/**
* ��������
* @param array $data ����
* @return boolean
**/
function set_config(
	$datas,
	$protect_fields = array(),
	$ignore_fields = array()
){
	/* //�����ϵͳû����װ�Ͳ�Ҫд�����˺�������
	if(empty($this->system->modules[$this->name]['installed']))
		return false; */
	
	//��������ֱ���˳�
	if(!$this->configurable) return false;
	
	$protect_fields = array_merge(
		$protect_fields,
		array()
	);
	
	$ignore_fields = array_merge(
		$ignore_fields,
		array(
			'alias' => 1,
			'class' => 1,
			'controller_class' => 1,
			'admin_actions' => 1,
			'actions' => 1,
			'credit_rule_actions' => 1
		)
	);
	
	$this->CONFIG = $this->core->_set_config(
		$this->system->name,
		$this->name, $this->path,
		$this->system->name .'/modules/',
		$this->name, $datas,
		$protect_fields,
		$ignore_fields
	);
	
	return true;
}

/**
* ģ��ҹ�
* @param string $system ϵͳ
* @param string $module ģ��
* @param string $id_field id�ֶ�
**/
function hook($system, $module, $id_field){
	return include PHP168_PATH .'inc/call/hook_module.call.php';
}

/**
* ȡ��ģ��ҹ�
* @param string $system ϵͳ
* @param string $module ģ��
**/
function unhook($system, $module){
	
	return include PHP168_PATH .'inc/call/unhook_module.call.php';
}

/**
* ɾ���ҹ�ģ�������,ֻ��ID��,�൱��ɽկ�����Լ��
**/
function delete_hook_module_item($ids){
	if(empty($this->system->CONFIG['hook_modules'][$this->name])) return false;
	
	//֪ͨ����Χ���߲�ȡ�ж�
	foreach($this->system->CONFIG['hook_modules'][$this->name] as $system => $v){
		//��������ϵͳ
		if($system == 'core'){
			//����ģ��
			$s = &$this->core;
		}else{
			$s = &$this->core->load_system($system);
		}
		
		foreach($v as $module => $id_field){
			//����ģ��
			$m = &$s->load_module($module);
			//���ùҹ�ɾ������
			$m->hook_delete($this, "#module_table#.$id_field IN ($ids)");
		}
	}
	return true;
}

/**
* ������ģ�鹴ɾ��,�����Ҫ�ٸ��ݸ���ģ��Ĳ�ͬ���и�����չ
* @param object $module_obj ģ����������
* @param string $cond ɾ������
* ���е�ģ��ɾ�����������Դ˸�ʽ function delete($data){}
* $data = array(
*	'where' => 'id IN (1,2,3)'		//ɾ������
*	'delete_hook' => true|false,	//�Ƿ�ɾ���ҹ�ģ�������
*	'hook' => true|false			//�ҹ�����ɾ��
* )
**/
function hook_delete(&$module_obj, $cond){
	//���ñ�ģ���ɾ�����ݺ���
	return $this->delete(array(
		'where' => str_replace('#module_table#', $this->table, $cond),
		'hook' => true
	));
}

/**
* ���ɻ���,�������վ��֪ͨ��վҲ���»���
**/
function cache(){
	
}

}
//ģ�Ͳ�(M)����
































  //##################//
 //#	���Ʋ���	#//
//##################//
class P8_Controller{

var $model,				//ģ�Ͳ��������Ǻ���,ϵͳ,ģ�����
	$core,				//���ú���
	$admin_actions,		//��̨����
	$actions,			//ǰ̨����
	$m_actions,			//ǰ����̨����
	$ACL,				//����Ȩ��
	$MACL,				//��������Ȩ��
	$ROLE,				//��ǰϵͳ��ɫ
	$UID,				//��ǰ��Աid
	$acl_postfix,		//��չ��Ȩ��
	$acl_m_postfix,		//��չ��Ȩ��
	$acl_path,			//Ȩ�޻���·��
	$no_base_acl,		//�޻�����Ȩ��
	$postfix_queue,		//��׺����
	$last_acl_cache,	//���һ�θ���Ȩ�޻���ʱ�����׺
	$last_user_acl_cache,	//���һ�θ��¸���Ȩ�޻���ʱ�����׺ 
	$DB_master,
	$DB_slave;

function __construct(&$obj){
	$this->model = &$obj;
	
	$this->init();
}

function P8_Controller(&$obj){
	$this->__construct($obj);
}

function init(){
	global $CACHE,$UID;
	
	switch($this->model->type){
	
	case 'core':
		//����
		$this->core = &$this->model;
		
		$this->acl_path = $this->model->name;
		$this->ROLE = $this->model->ROLE;
	break;
	
	case 'system':
		//ϵͳ
		$this->core = &$this->model->core;
		
		$this->acl_path = $this->model->name;
		$this->ROLE = $this->model->ROLE;
	break;
	
	case 'module':
		$this->core = &$this->model->core;
		
		if($this->model->system->name == 'core'){	//����ģ��
			$this->acl_path = $this->model->system->name .'/modules/'. $this->model->name;
			$this->ROLE = $this->model->core->ROLE;
		}else{	//ϵͳģ��
			$this->acl_path = $this->model->system->name .'/modules/'. $this->model->name;
			$this->ROLE = $this->model->system->ROLE;
		}
	break;
	
	}
    $this->UID = $UID;
	
	$this->last_acl_cache = '@'. $this->core->CONFIG['last_acl_cache'];
	$this->last_user_acl_cache = '@'. $this->core->CONFIG['last_user_acl_cache'];
	
	//���û�л���Ȩ�޿���,ֻ����չȨ���򲻶�������Ȩ��
	if(!$this->no_base_acl){
		$ACL = $CACHE->read($this->acl_path, 'acl', 'role_'. $this->ROLE . $this->last_acl_cache);
		//���ݽ�ɫ��ʼ������Ȩ��
		$this->admin_actions = empty($ACL['admin_actions']) ? array() : $ACL['admin_actions'];
		$this->actions = empty($ACL['actions']) ? array() : $ACL['actions'];
		
		unset($ACL['admin_actions'], $ACL['actions']);
		
		//��ʼ��ϸ��Ȩ��
		$this->ACL = $ACL;
		/**---------------����Ȩ��-----------------**/
		$MACL = $CACHE->read($this->acl_path, 'acl', 'user_'. $UID . $this->last_user_acl_cache);
		//���ݽ�ɫ��ʼ������Ȩ��
		$this->m_actions = empty($MACL['actions']) ? array() : $MACL['actions'];
		
		unset($MACL['admin_actions'], $MACL['actions']);
		
		//��ʼ��ϸ��Ȩ��
		$this->MACL = $MACL;
	}
	
	$this->acl_postfix = array();
	$this->acl_m_postfix = array();
	$this->postfix_queue = array();
	
	$this->DB_master = &$this->core->DB_master;
	$this->DB_slave = &$this->core->DB_slave;
	
	$this->_init();
}

/**
* ���า�ǵĳ�ʼ��
**/
function _init(){}

/**
* ����̨Ȩ��
* @param string $action ����
* @return boolean
**/
function check_admin_action($action, $postfix = ''){
	//����Ǵ�ʼ��ֱ�ӷ���
	global $IS_FOUNDER;
	if($IS_FOUNDER) return true;
	
	if($postfix && ($pos = array_search($postfix, $this->postfix_queue)) !== false){
		//�к�׺�����ҵ���׺
		
		//����׺��������Ȩ��
		if(!empty($this->acl_postfix[$this->postfix_queue[$pos]])){
			//������Ȩ��,����Ȩ��
			return !empty($this->acl_postfix[$this->postfix_queue[$pos]]['admin_actions'][$action]);
		}else if($pos != 0){
			//���û�����÷�����һ���׺Ȩ��,������һ���׺Ȩ�޲�Ϊ��
			if(!empty($this->acl_postfix[$this->postfix_queue[$pos -1]])){
				return !empty($this->acl_postfix[$this->postfix_queue[$pos -1]]['admin_actions'][$action]);
			}
		}
	}
	
	return !empty($this->admin_actions[$action]);
}

/**
* ���ǰ̨Ȩ��
* @param string $action ����
* @return boolean
**/
function check_action($action, $postfix = ''){

    //�Ȳ����Ȩ��
	if($this->check_m_action($action, $postfix))return true;
    
	//����Ǵ�ʼ��ֱ�ӷ���
	global $IS_FOUNDER;
	if($IS_FOUNDER) return true;
	
	if($postfix){
		$this->load_acl($postfix);
		if(($pos = array_search($postfix, $this->postfix_queue)) !== false){
		//�к�׺�����ҵ���׺
		
		//����׺��������Ȩ��
		if(!empty($this->acl_postfix[$this->postfix_queue[$pos]])){
			//������Ȩ��,����Ȩ��
			return !empty($this->acl_postfix[$this->postfix_queue[$pos]]['actions'][$action]);
		}else if($pos != 0){
			//���û�����÷�����һ���׺Ȩ��,������һ���׺Ȩ�޲�Ϊ��
			if(!empty($this->acl_postfix[$this->postfix_queue[$pos -1]])){
				return !empty($this->acl_postfix[$this->postfix_queue[$pos -1]]['actions'][$action]);
			}
		}
		}
	}
	
	//�޺�׺���Ĭ�ϵ�Ȩ��
	return !empty($this->actions[$action]);
}


/**
* ������ǰ̨Ȩ��
* @param string $action ����
* @return boolean
**/
function check_m_action($action, $postfix = ''){
	//����Ǵ�ʼ��ֱ�ӷ���
	global $IS_FOUNDER;
	if($IS_FOUNDER) return true;
    
    if($postfix){
		$this->load_m_acl($postfix);
		if(($pos = array_search($postfix, $this->postfix_queue)) !== false){
		//�к�׺�����ҵ���׺
		
		//����׺��������Ȩ��
		if(!empty($this->acl_m_postfix[$this->postfix_queue[$pos]])){
			//������Ȩ��,����Ȩ��
			return !empty($this->acl_m_postfix[$this->postfix_queue[$pos]]['actions'][$action]);
		}else if($pos != 0){
			//���û�����÷�����һ���׺Ȩ��,������һ���׺Ȩ�޲�Ϊ��
			if(!empty($this->acl_m_postfix[$this->postfix_queue[$pos -1]])){
				return !empty($this->acl_m_postfix[$this->postfix_queue[$pos -1]]['actions'][$action]);
			}
		}
		}
	}
	//�޺�׺���Ĭ�ϵ�Ȩ��
	return !empty($this->m_actions[$action]);
}

/**
* ȡ�ú�׺��Ȩ�ޱ�
* @param string $postfix ��׺
**/
function load_acl($postfix){
	$ACL = $this->core->CACHE->read($this->acl_path, 'acl', 'role_'. $this->ROLE .($postfix ? '#'. $postfix : ''). $this->last_acl_cache);
	//��׺���
	array_push($this->postfix_queue, $postfix);
	if(empty($ACL)) return false;
	
	$this->acl_postfix[$postfix]['admin_actions'] = empty($ACL['admin_actions']) ? array() : $ACL['admin_actions'];
	$this->acl_postfix[$postfix]['actions'] = empty($ACL['actions']) ? array() : $ACL['actions'];
	
	unset($ACL['admin_actions'], $ACL['actions']);
	$this->acl_postfix[$postfix]['ACL'] = $ACL;
}

/**
* ȡ�ø��˺�׺��Ȩ�ޱ�
* @param string $postfix ��׺
**/
function load_m_acl($postfix){
	$MACL = $this->core->CACHE->read($this->acl_path, 'acl', 'user_'. $this->UID .($postfix ? '#'. $postfix : ''). $this->last_user_acl_cache);
	//��׺���
	array_push($this->postfix_queue, $postfix);
	if(empty($MACL)) return false;
	
	$this->acl_m_postfix[$postfix]['actions'] = empty($MACL['actions']) ? array() : $MACL['actions'];
	
	unset($MACL['admin_actions'], $MACL['actions']);
	$this->acl_m_postfix[$postfix]['ACL'] = $MACL;
}
/**
* ȡ��admin_actions, actions �����Ȩ������
* @param string $key ��ֵ
* @param string $postfix ��׺
* @return mix �����û������,����null
**/
function get_o_acl($key, $postfix = ''){
	if($postfix){
		$this->load_acl($postfix);
		return isset($this->acl_postfix[$postfix]['ACL'][$key]) ? $this->acl_postfix[$postfix]['ACL'][$key] : null;
	}else{
		return isset($this->ACL[$key]) ? $this->ACL[$key] : null;
	}
}

/**
* ȡ��admin_actions, actions ����ĸ���Ȩ������
* @param string $key ��ֵ
* @param string $postfix ��׺
* @return mix �����û������,����null
**/
function get_m_acl($key, $postfix = ''){
	if($postfix){
        $this->load_m_acl($postfix);
		return isset($this->acl_m_postfix[$postfix]['ACL'][$key]) ? $this->acl_m_postfix[$postfix]['ACL'][$key] : null;
	}else{
		return isset($this->MACL[$key]) ? $this->MACL[$key] : null;
	}
}

function get_acl($key, $postfix = ''){

    $oacl = $this->get_o_acl($key, $postfix);
    $macl = $this->get_m_acl($key, $postfix);  
    if(!$macl && $oacl)return $oacl;
    if(!$oacl && $macl)return $macl;
    if(!$oacl && !$macl)return null;
    return $this->merge_array($oacl,$macl);
}


function merge_array($a,$b)
{
    $args=func_get_args();
    $res=array_shift($args);
    while(!empty($args))
    {
        $next=array_shift($args);
        foreach($next as $k => $v)
        {
            if(is_array($v) && isset($res[$k]) && is_array($res[$k]))
                $res[$k]=$this->merge_array($res[$k],$v);
            else if(empty($res[$k]))
                 $res[$k]=$v;
        }
    }
    return $res;
} 

}





























  //##################//
 //#	������		#//
//##################//
class P8_Cache{

var $memcache,
	$memcache_config,
	$prefix,
	$core;

function __construct(&$core){
	
	$this->core = &$core;
	
	if(!empty($core->CONFIG['memcache']['enabled'])){
		$this->memcache_config = $config = &$core->CONFIG['memcache'];
		
		$this->memcache = new memcache();
		
		foreach($config['server'] as $v){
			$this->memcache->addServer($v['host'], $v['port'], $config['pconnect']);
		}
		
		if($config['compress'])
			$this->memcache->setCompressThreshold(20000, 0.2);
		
		$this->prefix = $config['prefix'];
	}
}

/**
* 
**/
function P8_Cache(&$core){
	$this->__construct($core);
}

/**
* д����
* ��д����,�����Ի����ļ��ı���ľ���·����Ϊmemcache�ļ�ֵ����ȡ
* @param string $path ���汣���·��,�����/data/�ļ��µ����·��,��a/b, a/
* @param string $name ����ģ������,��Ҫ�� x/data/�н�����Ӧ���ļ���,��role,������/data/role��
* @param string $id ����id,�����id,�����ʽΪ$module_$id.php,���û��id��Ϊ$module.php,û��id�����һ�����ڱ���ģ���ܻ���
* @param array $data ������������
* @param string $type ���汣�������,Ĭ��Ϊvar_export�����ʽ,���߿�����serialize���л���ʽ
* @return boolean �Ƿ񱣴�ɹ�
* @example cache_write('a/', 'con', 'a', array());	���ݱ��浽/data/a/con_a.php
* @example cache_write('a/', 'con', '', array());	���ݱ��浽/data/a/con.php
**/
function write($path, $name, $id, $data, $type = 'var_export'){
	$_path = real_path(CACHE_PATH . $path);
	if(!$_path) return false;
	
	if($id){//�����ID����,��Ϊд�����ļ�,���û����д�ܻ���
		//CACHE_PATH . $path . $name
		
		if(is_int($id)){
			$tmp = '/'. intval($id / 1000) .'/';	//��ÿ���ļ��д洢���ļ�������1000
			$file = $name . $tmp . $name .'_'. $id .'.php';
			$name = $name . $tmp;
		}else{
			$file = $name .'/'. $name .'_'. $id .'.php';
		}
	}else{
		$file = $name .'/'. $name .'.php';
	}
	//Ŀ¼�����ڴ���
	md($_path . $name, true);
	$path = str_replace(CACHE_PATH, '', $_path);
	if($this->memcache){
		//���������memcache,�ѻ���ŵ�memcache��
		
		$status = $this->memcache_write($path . $file, $data);
	}
	
	/* $this->DB_master->insert(
		$this->core->TABLE_ .'cache',
		array(
			'path' => $path,
			'name' => $name,
			'id' => $id,
			'v' => $this->DB_master->escape_string(serialize($data))
		),
		array('replace' => true)
	); */
	
	//if($path == '' && $name == 'core' && $id == ''){
		$status = $this->file_write($_path . $file, $data, $type);
	//}
	
	return true;
}

/**
* ������
* @param string $path �����ȡ��·��,Ĭ�϶�ȡ��/data��,���ָ��Ϊarticle/,��ô��ȡ��article/data/��
* @param string $name ����ģ������,��Ҫ�� x/data/�н�����Ӧ���ļ���,��role,��ȡ��/data/role��
* @param string $id ����id,�����id,��ȡ��ʽΪ$module_$id.php,���û��id��Ϊ$name.php,û��id�����һ�����ڶ�ȡģ���ܻ���
* @param string $type �����ȡ������,Ĭ��Ϊvar_export�����ʽ,���߿�����serialize���л���ʽ
* @return array ��ȡ������
**/
function read($path, $name, $id = '', $type = 'var_export'){
	$_path = real_path(CACHE_PATH . $path);
	if(!$_path) return array();
	
	if($id){//�����ID����,��Ϊд�����ļ�,���û����д�ܻ���
		//CACHE_PATH . $path . $name
		
		if(is_int($id)){
			$tmp = '/'. intval($id / 1000) .'/';	//��ÿ���ļ��д洢���ļ�������1000
			$file = $name . $tmp . $name .'_'. $id .'.php';
			$name = $name . $tmp;
		}else{
			$file = $name .'/'. $name .'_'. $id .'.php';
		}
	}else{
		$file = $name .'/'. $name .'.php';
	}
	
	$path = str_replace(CACHE_PATH, '', $_path);
	if($this->memcache){
		//���������memcache,ֱ����memcache�ж�����
		
		$data = $this->memcache_read($path . $file);
		if(empty($data)){
			//�����memcache��û��������,���¶�һ���ļ�
			
			//$data = $this->db_read($path, $name, $id);
			$data = $this->file_read($_path . $file, $type);
			$this->memcache_write($path . $file, $data);
			return $data;
		}
		return $data;
	}else{
		//return $this->db_read($path, $name, $id);
		//echo $_path . $file."<br/>\n\r";
		return $this->file_read($_path . $file, $type);
	}
}

/**
* ɾ������
* @param string $path �����ȡ��·��,Ĭ�϶�ȡ��/data��,���ָ��Ϊarticle/,��ô��ȡ��article/data/��
* @param string $name ����ģ������,��Ҫ�� x/data/�н�����Ӧ���ļ���,��role,��ȡ��/data/role��
* @param string $id ����id,�����id,��ȡ��ʽΪ$module_$id.php,���û��id��Ϊ$module.php,û��id�����һ�����ڶ�ȡģ���ܻ���
* @return boolean
**/
function delete($path, $name, $id = ''){
	$_path = real_path(CACHE_PATH . $path);
	if(!$_path) return false;
	
	if($id){
		if(is_int($id)){
			$tmp = '/'. intval($id / 1000) .'/';	//��ÿ���ļ��д洢���ļ�������1000
			$file = $name . $tmp . $name .'_'. $id .'.php';
		}else{
			$file = $name .'/'. $name .'_'. $id .'.php';
		}
	}else{
		$file = $name .'/'. $name .'.php';
	}
	
	if($this->memcache){
		$path = str_replace(CACHE_PATH, '', $_path);
		$this->memcache_delete($path . $file);
	}
	
	/* $this->DB_master->delete(
		$this->core->TABLE_ .'cache',
		"path = '$path'" .($name == '*' ? '' : " AND name = '$name'"). ($id == '*' ? '' : " AND id = '$id'")
	); */
	
	if($id == '*'){
		rm($_path . $name, true);
		/*
		foreach(glob($_path . $file) as $v){
			@unlink($v);
		}*/
		return true;
	}else{
		return @unlink($_path . $file);
	}
}

function memcache_write($file, &$data){
	//д���浽memcache
	$this->memcache->set($this->prefix . $file, $data);
}

function memcache_read($file){
	//��memcache�������
	return $this->memcache->get($this->prefix . $file);
}

function memcache_delete($file){
	//��memcache��ɾ����
	return $this->memcache->delete($this->prefix . $file, 0);
}

function file_write($file, &$data, $type = 'var_export'){
	//д���浽�ļ�
	
	$fp = fopen($file, 'w');
	if(flock($fp, LOCK_EX)){
        ftruncate($fp , 0);
        $status = fwrite($fp, $type == 'var_export' ?
            "<?php\r\nreturn ". var_export($data, true) .";" :
            '<?php die();?>'. serialize($data)
            //��die��ֹ����й¶
        );
        flock($fp, LOCK_UN);
        fclose($fp);
        return $status;
    }else{
        return false;
    }
	
}

/*
function db_read($path, $name, $id = ''){

	$tmp = $this->DB_master->fetch_one("SELECT v FROM {$this->core->TABLE_}cache WHERE path = '$path' AND name = '$name' AND id = '$id'");
	return empty($tmp['v']) ? array() : mb_unserialize($tmp['v']);
}*/

function file_read($file, $type = 'var_export'){
	$data = null;
	//���ļ��������
	if($type == 'var_export'){
        if($this->core->CONFIG['debug'])
            $data = @include $file;
        else
            $data = @include $file;
	}else{
		//���л�
		$fp = @fopen($file, 'r');
		if($fp){
			flock($fp, LOCK_SH);
			//��λ��< ?php die();? >֮��
			fseek($fp, 14);
			$c = '';
			while(!feof($fp)){
				$c .= fgets($fp);
			}
			$data = @mb_unserialize($c);
			unset($c);
			flock($fp, LOCK_UN);
		}
	}
	
	if(empty($data))
		return array();
	return $data;
}

}