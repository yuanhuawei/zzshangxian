<?php
defined('PHP168_PATH') or die();

  //##################/
 //#	核心类		#/
//##################/
class P8_Core{

var $name,				//名称
	$CONFIG,			//配置
	$_CONFIG,			//配置
	$CACHE,				//缓存对象的引用
	$systems,			//现有的系统
	$_loaded_systems,	//己装载的系统
	$modules,			//己有的模块
	$_loaded_modules,	//己加载的模块
	$plugins,			//现有的插件
	$_loaded_plugins,	//己加载的插件
	$credits,			//积分种类
	$roles,				//角色
	$role_groups,		//角色组
	$_role_data,		//角色数据
	$path,				//核心的绝对路径
	$url,				//核心的URL
	$murl,				//核心的移动URL
	$controller,		//前台入口
	$mobile_controller,	//前台移动入口
	$admin_controller,	//后台入口
	$U_controller,		//会员中心入口
	$wap_controller,	//wap入口
	$DB_master,			//主数据库对象
	$DB_slave,			//从数据库对象
	$ROLE,				//角色
	$type,				//对象类型
	$TABLE_,			//核心表名前缀,与P8_TABLE_基本相同,可以设置核心数据库所在的前缀, php168.p8_,为多台PHP服务器共享一个核心数据库预留接口
	$member_table,		//核心会员表
	$attachment_table,	//附件表
	$attachment_url,	//附件表
	$RESOURCE,
	$clustered,			//是否集群
	
	$ismobile,			//是否移动设备
	$MOBILE;			//移动设备对象

function __construct(){
	
	$this->path = PHP168_PATH;
	$this->name = $this->type = 'core';
	
	$this->systems = $this->modules = $this->_loaded_systems = $this->_loaded_modules = array();
	//error_reporting(E_ALL);
	//核心配置

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
	
	//访问地址
	$this->url = &$this->CONFIG['url'];
	$this->RESOURCE = empty($this->CONFIG['resource_url']) ? $this->url : $this->CONFIG['resource_url'];
	
	//是否开启rewrite功能隐藏index.php
	$this->controller = $this->url .(empty($this->CONFIG['url_rewrite_enabled']) ? '/index.php' : '');
	
	$this->admin_controller = empty($this->CONFIG['admin_controller']) ? rtrim($this->url,'/') .'/admin.php' : rtrim($this->url,'/'). '/' . $this->CONFIG['admin_controller'];
	
	$this->U_controller = $this->CONFIG['url'] .'/u.php';
	
	$this->systems = &$this->CONFIG['system&module'];
	$this->modules = &$this->CONFIG['modules'];
	$this->plugins = &$this->CONFIG['plugins'];
	$this->credits = &$this->CONFIG['credits'];
	$this->clustered = !empty($this->modules['cluster']['installed']) && !empty($this->modules['cluster']['enabled']);
	$this->attachment_url = $this->url .'/'. $this->CONFIG['attachment']['path'];
	
	//初始化主数据库
	$this->DB_connect();
	$this->DB_connect('slave');
	
	//初始化移动
	$this->int_mobile();
	
}

function P8_Core(){
	$this->__construct();
}


/**
* 加载系统
* @param string $name 系统名称
* @return object 系统对象
**/
function &load_system($name){
	$name = strtolower($name);
	//每个系统只允许装载一次
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
* 列出所有系统
* @param boolean $refresh 是否重新列出, 默认读取缓存
* @return array 现有系统的数组
* 本函数会进行缓存
**/
function list_systems($refresh = false){
	
	if($refresh){
		return include PHP168_PATH .'inc/call/refresh_systems.call.php';
	}else{
		
		return empty($this->systems) ? $this->systems = &$this->CONFIG['system&module'] : $this->systems;
	}
}

/**
* 加载系统的模块
* @param string $name 模块名称
* @return object 模块对象
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
* 核心模块的列表
* @param boolean $refresh 是否重新列出, 默认读取缓存
* @return array 核心现有模块的数组
**/
function list_modules($refresh = false){
	
	if($refresh){
		return include PHP168_PATH .'inc/call/refresh_core_modules.call.php';
	}else{

		return empty($this->modules) ? $this->modules = &$this->CONFIG['modules'] : $this->modules;
	}

}

/**
* 应用控制层
* @param object $obj 核心,系统,模块对象
* @return object 控制层对象
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
* 语言包列表
* @param bool $refresh 是否重新列出
**/
function list_language($refresh = false){
	//if(isset($this->CONFIG['language'])) return $this->CONFIG['language'];
	return include PHP168_PATH .'inc/call/list_language.call.php';
}

/**
* 模板列表
* @param bool $refresh 是否重新列出
**/
function list_templates($refresh = false){
	return include PHP168_PATH .'inc/call/list_templates.call.php';
}

/**
* 获取配置
* @param string $system 系统名称
* @param string $module 模块名称
* @return array 配置
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
* 写配置
* 配置表格式
* system(系统)	module(模块)	type(数据类型)		key(键值)		value(值)
*
* core							string				lang			zh-cn			//核心语言配置
* b				business_sell	serialize			某项配置		序列化的数组	//商务务系统某项数组配置
* @param array $datas 格式array('key' => 'value'), 要写入的数据,只写局部数据
* @param array $protect_fields 保护字段,不会写进数据库
* @param boolean 是否写成功了
**/
function set_config(
	$datas,
	$protect_fields = array(),
	$ignore_fields = array()
){
	$protect_fields = array_merge(
		$protect_fields,
		array(
			//mysql可选连接类型
			'mysql_connect_types' => 1,
			//主数据库配置
			'DB_master' => 1,
			//可选的编码函数
			'encode_conv_functions' => 1,
			//表前缀
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
* 统一写配置
* @param string $system 系统名称
* @param string $module 模块名称
* @param string $path 系统/模块的绝对路径
* @param string $cache_path 系统/模块的缓存路径
* @param string $cache_name 系统/模块的缓存名称
* @param mix $datas 系统/模块的缓存内容
* @param array $protect_fields 系统/模块的保护字段,不写进数据库但会写进缓存
* @param array $ignore_fields 系统/模块的不被写入数据库也不会被入缓存的字段
**/
function _set_config(
	$system,
	$module,
	$path,
	$cache_path,
	$cache_name,
	$datas,
	$protect_fields = array(),	//保护字段,不会写入数据库也但会重新写到缓存,可用于手动修改
	$ignore_fields = array()	//忽略字段,不会写入数据库也不会写到缓存
){
	global $_syn_configs;
	$_syn_configs[$system][$module] = 1;
	//同步配置
	
	$info = include $path .'#.php';
	
	$query = $this->DB_master->query("SELECT type, k, v FROM {$this->TABLE_}config WHERE system = '$system' AND module = '$module'");
	$config = array();
	while($v = $this->DB_master->fetch_array($query)){
		$config[$v['k']] = $v['type'] == 'serialize' ? mb_unserialize($v['v']) : $v['v'];
		unset($info[$v['k']]);		//如果数据库里的值已经有了,删掉#.php的值
	}
	
	//去除魔法引号
	//$datas = p8_stripslashes2($datas);
	//输入的配置
	$datas = array_merge($info, $datas);	//$datas覆盖$info的值
	unset($info);
	
	//用于插入数据库
	$db_datas = array();
	foreach($datas as $k => $v){
		if(isset($protect_fields[$k])){
			continue;
		}
		if(isset($ignore_fields[$k])){
			unset($datas[$k]);
			continue;
		}
		
		//新增的配置
		$config[$k] = $v;
		$_k = $this->DB_master->escape_string($k);	//进行过滤
		$type = 'string';
		
		$_v = $v;
		if(is_array($v) || is_object($v)){
			$_v = serialize($v);//如果是数组或对象就进行序列化
			$type = 'serialize';
		}
		$_v = $this->DB_master->escape_string($_v);	//进行过滤
		
		$db_datas[] = array($system, $module, $type, $_k, $_v);
	}
	
	//批量替换
	$this->DB_master->insert(
		$this->TABLE_ .'config',
		$db_datas,
		array(
			'multiple' => array('system' ,'module' ,'type' ,'k' ,'v'),
			'replace' => true
		)
	);
	
	$datas = array_merge($datas, $config);	//$config 覆盖 $datas的值
	unset($config, $db_datas);
	
	//写缓存
	
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
* 连接数据库
* @param string $type 连接类型,master为主数据库,slave为从数据库,实现读写分离
* @return boolean
**/
function DB_connect($type = 'master'){
	$mysql_connect_type = isset($this->CONFIG['mysql_connect_type'])?$this->CONFIG['mysql_connect_type']: 'mysql';
	$mysql_connect_charset = isset($this->CONFIG['mysql_charset'])?$this->CONFIG['mysql_charset']: 'gbk';
	$mysql_connect_port = isset($this->CONFIG['mysql_connect_port'])?$this->CONFIG['mysql_connect_port']: 3306;
	require_once PHP168_PATH .'inc/'. $mysql_connect_type .'.class.php';
	
	//连接读数据库
	if($type == 'slave'){
		//初始化过就退出
		if(is_object($this->DB_slave)) return true;
		
		if(!isset($this->CONFIG['DB_slave']) || ($count = count($this->CONFIG['DB_slave'])) == 0){
			$this->DB_connect('master');
			$this->DB_slave = &$this->DB_master;
			return true;
		}
		
		//如果只有一个从,并且从的配置等于主的配置,则把从设为主引用
		if($count == 1 && $this->CONFIG['DB_slave'][0] == $this->CONFIG['DB_master']){
			$this->DB_slave = &$this->DB_master;
		}else{//有多个从
			//随机抽出一个来连接
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
		//写
		if(is_object($this->DB_master)) return true;
		
		if(empty($this->CONFIG['DB_master'])) die('没有设置数据库');
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
* 获得URL路由
**/
function get_router(){
	list($uri, ) = explode('?', $_SERVER['_REQUEST_URI'], 2);
	global $__FILE__;
	$self = basename($__FILE__);
	substr($uri, -1) == '/' && $uri .= $self;
	$uri = substr(preg_replace('|^/.*'. $self .'|U', '', $uri), 1);
	
	if(empty($uri)) return array();
	
	//只分割1个/
	$s = explode('/', $uri, 2);
	
	return $s;
}

/**
* (分页)列表
* @param object $select select对象
* @param int $page 页数
* @param int $page_size 每页的条数
* @param int $count 查找的记录条数
* @return array 结果集
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
	
	//是否需要分页,如果page = 0,不用分页
	$list_page = $options['page'] && $options['page_size'];
	
	if($options['db_obj']){
		$db = &$options['db_obj'];
	}else if($options['ms'] == 'master'){
		$db = &$this->DB_master;
	}else{
		$db = &$this->DB_slave;
	}
	
	//如果开启了sphinx搜索
	if(!empty($options['sphinx']['enabled'])){
		if($list_page){
			//如果需要分页
			$select->limit(($options['page'] -1) * $options['page_size'], $options['page_size']);
		}else if($options['page_size']){
			//不分页但限制条数
			$select->limit(0, $options['page_size']);
		}
		
		$result = p8_sphinx_fetch($select, $options['sphinx']);
		
		$datas = $ids = array();
		if(empty($result['matches'])) return $datas;
		
		//如果有匹配的行
		foreach($result['matches'] as $v){
			$datas[$v['id']] = array('id' => $v['id']);
			$ids[] = $v['id'];
		}//取回主键集
		
		//清除所有条件
		$select->sphinx_clear();
		
		//只取第一个from部分的ID来作条件,$select->from('first_from AS i', 'i.*'), 即i.id会被使用
		$alias = array_shift(array_keys($select->_from));
		$select->in($alias .'.id', $ids);
		//重新写primary IN ($ids)的where条件来取数据
		$query = $this->select($select, array('ms' => $options['ms'], 'return' => 'query', 'db_obj' => &$options['db_obj']));
		
		//将返回的ID顺序纠正, 3, 1, 2这种顺序在SQL查询后会返回1,2,3
		while($arr = $db->fetch_array($query)){
			$datas[$arr['id']] = $arr;
		}
		
		if($list_page){
			//总共找到多少条记录
			$options['count'] = $result['total_found'];
			//分页数
			$pages = ceil($options['count'] / $options['page_size']);
		}
		
		//返回以下标为0开头的数组
		return array_values($datas);
		
	}else{
		//默认的数据库查询
		if($list_page){
			//如果需要分页
			
			if($options['count'] <= 0){
				$count = $db->fetch_one($select->build_count_sql());
				
				$options['count'] = $count['num'];
			}
			
			//没有条数直接返回空数组
			if($options['count'] == 0) return array();
			
			$pages = ceil($options['count'] / $options['page_size']);
			$options['page'] = min($pages, $options['page']);
			$select->limit(($options['page'] -1) * $options['page_size'], $options['page_size']);
		}else if($options['page_size']){
			//不分页但限制条数
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
* 读操作
* @param object $select select构造SQL的对象
**/
function select(&$select, $option = array()){
	
	$option['single'] = empty($option['single']) ? false : true;
	$option['ms'] = isset($option['single']) && $option['ms'] = 'master' ? 'master' : 'slave';
	//以键值返回
	$option['key_for_return'] = empty($option['key_for_return']) ? '' : $option['key_for_return'];
	//返回query或数组
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
* 更新会员的积分
* @param int $uid 会员id
* @param array $credits 积分ID => 积分
* @param bool $add 是否运算+,如credit +1,如果不是则把积分设置为credits里面的值, credit = 1
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
* 获得会员的积分
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
* @param int $uid 用户ID
* @param int $source_id 源积分ID
* @param int $target_id 目标积分ID
* @param int|float $amount 要兑换目标积分的数量
**/
function exchange_credit($uid, $source_id, $target_id, $amount){
	//如果汇率不存在直接返回
	if(empty($this->credits[$source_id]['roe'][$target_id])) return false;
	
	$need = ceil($amount / $this->credits[$source_id]['roe'][$target_id]);
	
	$credits = $this->get_credit($uid);
	//积分不足
	if($credits[$source_id] < $need) return false;
	
	$data = array($target_id => $amount, $source_id => -$need);
	
	return $this->update_credit($uid, $data);
}

/**
* 获取核心模块的缓存
**/
function get_cache($type){
	switch($type){
	
	//角色缓存
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
	
	//角色组缓存
	case 'role_group':
		if(empty($this->role_groups)){
			global $CACHE;
			$this->role_groups = $CACHE->read('core/modules', 'role', 'groups');
		}
	break;
	
	//权限缓存
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
* 注销系统或模块
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
* 整合
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
 //#	系统继承类	#/
//##################/
class P8_System{

var $CONFIG,			//配置
	$_loaded_modules,	//己加载的模块
	$modules,			//包含的模块
	$path,				//系统的绝对路径
	$name,				//系统名称
	$url,				//系统的URL
	$murl,				//系统的URL
	$controller,		//系统入口
	$mobile_controller,		//系统入口
	$admin_controller,
	$U_controller,
	$core,				//引用核心
	$ROLE,
	$table,
	$TABLE_,
	$member_table,		//系统会员表
	$attachment_table,	//附件表
	$type,
	$DB_master,
	$DB_slave;

function __construct($name){
	
	$this->path = PHP168_PATH . $name . '/';
	$this->name = $name;
	$this->type = 'system';
	
	$this->modules = array();
	
	//获取模块列表
	$this->list_modules();
	
	//加载系统配置
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
* 构造函数
* @param string $name 系统名称
**/
function P8_System($name){
	$this->__construct($name);
}

/**
* 取得当前用户在当前系统的角色
**/
function get_role(){
	
	if($this->ROLE) return true;
	
	global $UID, $USERNAME, $_P8SESSION;
	
	if($UID){
		$name = $this->name;
		if(!empty($_P8SESSION['role@system'][$name])){
			//已经设置过了
			$this->ROLE = $_P8SESSION['role@system'][$name];
			return true;
		}
		
		$member = $this->DB_master->fetch_one("SELECT * FROM $this->member_table WHERE id = '$UID'");
		
		if(empty($member)){
			//如果本系统的会员没有激活,先设置个默认的会员权限
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
			//本系统的角色
			$this->ROLE = $_P8SESSION['role@system'][$this->name] = $member['role_id'];
		}
		
		//unset($member['id'], $member['username'], $member['role_id']);
		
		//$_P8SESSION[$this->name .'_member_info'] = $member;
	}else{
		//没有登录回归到本系统的游客角色
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
	
	/* //如果本系统没被安装就不要写缓存了和配置了
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

//-------------------模块函数------------------------
/**
* 加载系统的模块
* @param string $name 模块名称
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
* 系统模块的列表
* @param boolean $refresh 是否重新列出, 默认读取缓存
* @return array 系统现有模块的数组
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
 //#	模块继承类	#/
//##################/
class P8_Module{


var $name;				//模块名称
var $path;				//模块的绝对路径
var $CONFIG;			//配置
var $url;				//URL
var $murl;				//URL
var $controller;		//模块入口
var $admin_controller;
var $U_controller;
var $mobile_controller;
var $system;			//对系统对象的引用,可以直接调用所属系统的方法
var $core;				//核心引用
var $configurable = true;//是否可配置,继承时将此属性置为false,加载时不会读配置
var $TABLE_;			//表名前缀
var $table;
var $type;				//对象类型
var $DB_master;
var $DB_slave;

function __construct($name){
	
	$this->path = $this->system->path .'modules/'. $name .'/';
	$this->name = $name;
	$this->type = 'module';
	
	//配置,如果模块可配置,加载配置
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
* 构造函数
* @param string $name 系统的模块名称
**/
function P8_Module($name){
	$this->__construct($name);
}

/**
* 保存配置
* @param array $data 数据
* @return boolean
**/
function set_config(
	$datas,
	$protect_fields = array(),
	$ignore_fields = array()
){
	/* //如果本系统没被安装就不要写缓存了和配置了
	if(empty($this->system->modules[$this->name]['installed']))
		return false; */
	
	//不可配置直接退出
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
* 模块挂勾
* @param string $system 系统
* @param string $module 模块
* @param string $id_field id字段
**/
function hook($system, $module, $id_field){
	return include PHP168_PATH .'inc/call/hook_module.call.php';
}

/**
* 取消模块挂勾
* @param string $system 系统
* @param string $module 模块
**/
function unhook($system, $module){
	
	return include PHP168_PATH .'inc/call/unhook_module.call.php';
}

/**
* 删除挂勾模块的数据,只传ID集,相当于山寨的外键约束
**/
function delete_hook_module_item($ids){
	if(empty($this->system->CONFIG['hook_modules'][$this->name])) return false;
	
	//通知所有围观者采取行动
	foreach($this->system->CONFIG['hook_modules'][$this->name] as $system => $v){
		//加载所在系统
		if($system == 'core'){
			//核心模块
			$s = &$this->core;
		}else{
			$s = &$this->core->load_system($system);
		}
		
		foreach($v as $module => $id_field){
			//加载模块
			$m = &$s->load_module($module);
			//调用挂勾删除函数
			$m->hook_delete($this, "#module_table#.$id_field IN ($ids)");
		}
	}
	return true;
}

/**
* 基础的模块勾删除,如果需要再根据各个模块的不同进行覆盖扩展
* @param object $module_obj 模块对象的引用
* @param string $cond 删除条件
* 所有的模块删除函数必须以此格式 function delete($data){}
* $data = array(
*	'where' => 'id IN (1,2,3)'		//删除条件
*	'delete_hook' => true|false,	//是否删除挂钩模块的数据
*	'hook' => true|false			//挂钩连锁删除
* )
**/
function hook_delete(&$module_obj, $cond){
	//调用本模块的删除数据函数
	return $this->delete(array(
		'where' => str_replace('#module_table#', $this->table, $cond),
		'hook' => true
	));
}

/**
* 生成缓存,如果有子站会通知子站也更新缓存
**/
function cache(){
	
}

}
//模型层(M)结束
































  //##################//
 //#	控制层类	#//
//##################//
class P8_Controller{

var $model,				//模型层对象可以是核心,系统,模块对象
	$core,				//引用核心
	$admin_actions,		//后台操作
	$actions,			//前台操作
	$m_actions,			//前个人台操作
	$ACL,				//其他权限
	$MACL,				//其他个人权限
	$ROLE,				//当前系统角色
	$UID,				//当前会员id
	$acl_postfix,		//扩展的权限
	$acl_m_postfix,		//扩展的权限
	$acl_path,			//权限缓存路径
	$no_base_acl,		//无基础的权限
	$postfix_queue,		//后缀队列
	$last_acl_cache,	//最后一次更新权限缓存时间戳后缀
	$last_user_acl_cache,	//最后一次更新个人权限缓存时间戳后缀 
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
		//核心
		$this->core = &$this->model;
		
		$this->acl_path = $this->model->name;
		$this->ROLE = $this->model->ROLE;
	break;
	
	case 'system':
		//系统
		$this->core = &$this->model->core;
		
		$this->acl_path = $this->model->name;
		$this->ROLE = $this->model->ROLE;
	break;
	
	case 'module':
		$this->core = &$this->model->core;
		
		if($this->model->system->name == 'core'){	//核心模块
			$this->acl_path = $this->model->system->name .'/modules/'. $this->model->name;
			$this->ROLE = $this->model->core->ROLE;
		}else{	//系统模块
			$this->acl_path = $this->model->system->name .'/modules/'. $this->model->name;
			$this->ROLE = $this->model->system->ROLE;
		}
	break;
	
	}
    $this->UID = $UID;
	
	$this->last_acl_cache = '@'. $this->core->CONFIG['last_acl_cache'];
	$this->last_user_acl_cache = '@'. $this->core->CONFIG['last_user_acl_cache'];
	
	//如果没有基础权限控制,只有扩展权限则不读基础的权限
	if(!$this->no_base_acl){
		$ACL = $CACHE->read($this->acl_path, 'acl', 'role_'. $this->ROLE . $this->last_acl_cache);
		//根据角色初始化二制权限
		$this->admin_actions = empty($ACL['admin_actions']) ? array() : $ACL['admin_actions'];
		$this->actions = empty($ACL['actions']) ? array() : $ACL['actions'];
		
		unset($ACL['admin_actions'], $ACL['actions']);
		
		//初始化细节权限
		$this->ACL = $ACL;
		/**---------------个人权限-----------------**/
		$MACL = $CACHE->read($this->acl_path, 'acl', 'user_'. $UID . $this->last_user_acl_cache);
		//根据角色初始化二制权限
		$this->m_actions = empty($MACL['actions']) ? array() : $MACL['actions'];
		
		unset($MACL['admin_actions'], $MACL['actions']);
		
		//初始化细节权限
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
* 子类覆盖的初始化
**/
function _init(){}

/**
* 检查后台权限
* @param string $action 动作
* @return boolean
**/
function check_admin_action($action, $postfix = ''){
	//如果是创始人直接返回
	global $IS_FOUNDER;
	if($IS_FOUNDER) return true;
	
	if($postfix && ($pos = array_search($postfix, $this->postfix_queue)) !== false){
		//有后缀并且找到后缀
		
		//检查后缀有无设置权限
		if(!empty($this->acl_postfix[$this->postfix_queue[$pos]])){
			//有设置权限,返回权限
			return !empty($this->acl_postfix[$this->postfix_queue[$pos]]['admin_actions'][$action]);
		}else if($pos != 0){
			//如果没有设置返回上一层后缀权限,并且上一层后缀权限不为空
			if(!empty($this->acl_postfix[$this->postfix_queue[$pos -1]])){
				return !empty($this->acl_postfix[$this->postfix_queue[$pos -1]]['admin_actions'][$action]);
			}
		}
	}
	
	return !empty($this->admin_actions[$action]);
}

/**
* 检查前台权限
* @param string $action 动作
* @return boolean
**/
function check_action($action, $postfix = ''){

    //先查个人权限
	if($this->check_m_action($action, $postfix))return true;
    
	//如果是创始人直接返回
	global $IS_FOUNDER;
	if($IS_FOUNDER) return true;
	
	if($postfix){
		$this->load_acl($postfix);
		if(($pos = array_search($postfix, $this->postfix_queue)) !== false){
		//有后缀并且找到后缀
		
		//检查后缀有无设置权限
		if(!empty($this->acl_postfix[$this->postfix_queue[$pos]])){
			//有设置权限,返回权限
			return !empty($this->acl_postfix[$this->postfix_queue[$pos]]['actions'][$action]);
		}else if($pos != 0){
			//如果没有设置返回上一层后缀权限,并且上一层后缀权限不为空
			if(!empty($this->acl_postfix[$this->postfix_queue[$pos -1]])){
				return !empty($this->acl_postfix[$this->postfix_queue[$pos -1]]['actions'][$action]);
			}
		}
		}
	}
	
	//无后缀检查默认的权限
	return !empty($this->actions[$action]);
}


/**
* 检查个人前台权限
* @param string $action 动作
* @return boolean
**/
function check_m_action($action, $postfix = ''){
	//如果是创始人直接返回
	global $IS_FOUNDER;
	if($IS_FOUNDER) return true;
    
    if($postfix){
		$this->load_m_acl($postfix);
		if(($pos = array_search($postfix, $this->postfix_queue)) !== false){
		//有后缀并且找到后缀
		
		//检查后缀有无设置权限
		if(!empty($this->acl_m_postfix[$this->postfix_queue[$pos]])){
			//有设置权限,返回权限
			return !empty($this->acl_m_postfix[$this->postfix_queue[$pos]]['actions'][$action]);
		}else if($pos != 0){
			//如果没有设置返回上一层后缀权限,并且上一层后缀权限不为空
			if(!empty($this->acl_m_postfix[$this->postfix_queue[$pos -1]])){
				return !empty($this->acl_m_postfix[$this->postfix_queue[$pos -1]]['actions'][$action]);
			}
		}
		}
	}
	//无后缀检查默认的权限
	return !empty($this->m_actions[$action]);
}

/**
* 取得后缀的权限表
* @param string $postfix 后缀
**/
function load_acl($postfix){
	$ACL = $this->core->CACHE->read($this->acl_path, 'acl', 'role_'. $this->ROLE .($postfix ? '#'. $postfix : ''). $this->last_acl_cache);
	//后缀入队
	array_push($this->postfix_queue, $postfix);
	if(empty($ACL)) return false;
	
	$this->acl_postfix[$postfix]['admin_actions'] = empty($ACL['admin_actions']) ? array() : $ACL['admin_actions'];
	$this->acl_postfix[$postfix]['actions'] = empty($ACL['actions']) ? array() : $ACL['actions'];
	
	unset($ACL['admin_actions'], $ACL['actions']);
	$this->acl_postfix[$postfix]['ACL'] = $ACL;
}

/**
* 取得个人后缀的权限表
* @param string $postfix 后缀
**/
function load_m_acl($postfix){
	$MACL = $this->core->CACHE->read($this->acl_path, 'acl', 'user_'. $this->UID .($postfix ? '#'. $postfix : ''). $this->last_user_acl_cache);
	//后缀入队
	array_push($this->postfix_queue, $postfix);
	if(empty($MACL)) return false;
	
	$this->acl_m_postfix[$postfix]['actions'] = empty($MACL['actions']) ? array() : $MACL['actions'];
	
	unset($MACL['admin_actions'], $MACL['actions']);
	$this->acl_m_postfix[$postfix]['ACL'] = $MACL;
}
/**
* 取得admin_actions, actions 以外的权限设置
* @param string $key 键值
* @param string $postfix 后缀
* @return mix 如果是没有设置,返回null
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
* 取得admin_actions, actions 以外的个人权限设置
* @param string $key 键值
* @param string $postfix 后缀
* @return mix 如果是没有设置,返回null
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
 //#	缓存类		#//
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
* 写缓存
* 读写缓存,都是以缓存文件的保存的绝对路径作为memcache的键值来读取
* @param string $path 缓存保存的路径,相对于/data/文件下的相对路径,如a/b, a/
* @param string $name 缓存模块名称,需要在 x/data/中建立相应的文件夹,如role,保存在/data/role中
* @param string $id 缓存id,如果有id,保存格式为$module_$id.php,如果没有id则为$module.php,没有id的情况一般用于保存模块总缓存
* @param array $data 缓存数组数据
* @param string $type 缓存保存的类型,默认为var_export数组格式,或者可以是serialize序列化格式
* @return boolean 是否保存成功
* @example cache_write('a/', 'con', 'a', array());	数据保存到/data/a/con_a.php
* @example cache_write('a/', 'con', '', array());	数据保存到/data/a/con.php
**/
function write($path, $name, $id, $data, $type = 'var_export'){
	$_path = real_path(CACHE_PATH . $path);
	if(!$_path) return false;
	
	if($id){//如果有ID传入,则为写单个文件,如果没有则写总缓存
		//CACHE_PATH . $path . $name
		
		if(is_int($id)){
			$tmp = '/'. intval($id / 1000) .'/';	//让每个文件夹存储的文件不超过1000
			$file = $name . $tmp . $name .'_'. $id .'.php';
			$name = $name . $tmp;
		}else{
			$file = $name .'/'. $name .'_'. $id .'.php';
		}
	}else{
		$file = $name .'/'. $name .'.php';
	}
	//目录不存在创建
	md($_path . $name, true);
	$path = str_replace(CACHE_PATH, '', $_path);
	if($this->memcache){
		//如果设置了memcache,把缓存放到memcache中
		
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
* 读缓存
* @param string $path 缓存读取的路径,默认读取在/data中,如果指定为article/,那么读取在article/data/中
* @param string $name 缓存模块名称,需要在 x/data/中建立相应的文件夹,如role,读取在/data/role中
* @param string $id 缓存id,如果有id,读取格式为$module_$id.php,如果没有id则为$name.php,没有id的情况一般用于读取模块总缓存
* @param string $type 缓存读取的类型,默认为var_export数组格式,或者可以是serialize序列化格式
* @return array 读取的数据
**/
function read($path, $name, $id = '', $type = 'var_export'){
	$_path = real_path(CACHE_PATH . $path);
	if(!$_path) return array();
	
	if($id){//如果有ID传入,则为写单个文件,如果没有则写总缓存
		//CACHE_PATH . $path . $name
		
		if(is_int($id)){
			$tmp = '/'. intval($id / 1000) .'/';	//让每个文件夹存储的文件不超过1000
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
		//如果设置了memcache,直接在memcache中读缓存
		
		$data = $this->memcache_read($path . $file);
		if(empty($data)){
			//如果在memcache里没读到缓存,重新读一次文件
			
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
* 删除缓存
* @param string $path 缓存读取的路径,默认读取在/data中,如果指定为article/,那么读取在article/data/中
* @param string $name 缓存模块名称,需要在 x/data/中建立相应的文件夹,如role,读取在/data/role中
* @param string $id 缓存id,如果有id,读取格式为$module_$id.php,如果没有id则为$module.php,没有id的情况一般用于读取模块总缓存
* @return boolean
**/
function delete($path, $name, $id = ''){
	$_path = real_path(CACHE_PATH . $path);
	if(!$_path) return false;
	
	if($id){
		if(is_int($id)){
			$tmp = '/'. intval($id / 1000) .'/';	//让每个文件夹存储的文件不超过1000
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
	//写缓存到memcache
	$this->memcache->set($this->prefix . $file, $data);
}

function memcache_read($file){
	//从memcache里读缓存
	return $this->memcache->get($this->prefix . $file);
}

function memcache_delete($file){
	//从memcache里删缓存
	return $this->memcache->delete($this->prefix . $file, 0);
}

function file_write($file, &$data, $type = 'var_export'){
	//写缓存到文件
	
	$fp = fopen($file, 'w');
	if(flock($fp, LOCK_EX)){
        ftruncate($fp , 0);
        $status = fwrite($fp, $type == 'var_export' ?
            "<?php\r\nreturn ". var_export($data, true) .";" :
            '<?php die();?>'. serialize($data)
            //用die防止数据泄露
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
	//从文件里读缓存
	if($type == 'var_export'){
        if($this->core->CONFIG['debug'])
            $data = @include $file;
        else
            $data = @include $file;
	}else{
		//序列化
		$fp = @fopen($file, 'r');
		if($fp){
			flock($fp, LOCK_SH);
			//定位到< ?php die();? >之后
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