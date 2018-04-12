<?php
defined('PHP168_PATH') or die();

/** 插件,在模板插入 $plugin[插件名称] 就可以调用插件了 **/
class P8_Plugin{

var $type;					//对象类型
var $core;					//核心的引用
var $CONFIG;				//配置
var $name;					//插件名称
var $path;					//插件路径
var $TABLE_;				//表名前缀
var $configurable = true;	//可配置?
var $_data;
var $_var_data;
var $url;					//插件URL
var $controller;			//插件入口
var $DB_master;
var $DB_slave;

function __construct($name){
	$this->type = 'plugin';
	$this->name = $name;
	$this->path = PHP168_PATH .'plugin/'. $this->name .'/';
	$this->TABLE_ = $this->core->TABLE_ .'plugin_'. $this->name .'_';
	$this->_var_data = array();
	$this->controller = $this->core->url .'/plugin.php/'. $this->name;
	$this->url = $this->core->url .'/plugin/'. $this->name .'/';
	
	if($this->configurable){
		//加载配置
		$this->CONFIG = $this->get_config();
	}
	
	$this->DB_master = &$this->core->DB_master;
	$this->DB_slave = &$this->core->DB_slave;
	
	//加载语言包
	load_language($this->core, 'plugin/'. $this->name .'/global');
}

function P8_Plugin($name){
	$this->__construct($name);
}

/**
* 插件配置
**/
function set_config(
	$datas,
	$protected_fields = array(),
	$ignore_fields = array('name' => 1, 'alias' => 1, 'class' => 1)
){
	
	$this->CONFIG = $this->core->_set_config(
		'core',
		'plugin_'. $this->name,
		$this->path,
		'core/plugin',
		$this->name,
		$datas,
		$protected_fields,
		$ignore_fields
	);
}

/**
* 获取插件配置
* @param bool $cache 是否从缓存里面读取配置,否则从数据库里读取
**/
function get_config($cache = true){
	if($cache){
		global $CACHE;
		return $CACHE->read('core/plugin', $this->name);
	}else{
		return $this->core->get_config('core', 'plugin_'. $this->name);
	}
}

/**
* 写本插件的缓存
**/
function cache($name, $value = null){
	global $CACHE;
	if($value === null){
		return $CACHE->read('core/plugin', $this->name, $name);
	}else{
		return $CACHE->write('core/plugin', $this->name, $name, $value);
	}
}

/**
* 获取模板
* @param string $template 模板名称,路径相对于当前插件的目录/template/plugin/$this->name/$template
* @return string 返回编译好的模板路径
**/
function template($template){
	$file = CACHE_PATH .'template/plugin/'. $this->name .'/'. $template .'.php';
	if(
		!is_file($file) || 
		filemtime(TEMPLATE_PATH .'plugin/'. $this->name .'/'. $template .'.html') > filemtime($file)
	){
		include_once PHP168_PATH .'inc/template.func.php';
		
		return template_cache('plugin/', '', $this->name .'/'. $template);
	}
	
	return $file;
}

/**
* 缓存己显示的数据
**/
function cache_data($data, $v){
	if(is_array($v)){
		$hash = md5(serialize($v));
		$this->_var_data[$hash] = $data;
	}else{
		$this->_data = $data;
	}
}

/**
* 插件显示函数,通过此函数显示插件的内容
* @param array $v 用于获取页面上变量的数组
* @return string
**/
function display($v = null){
	
	if(is_array($v)){
		$var = true;
		$hash = md5(serialize($v));
		
		if(isset($this->_var_data[$hash]))
			return $this->_var_data[$hash];
	}else{
		$var = false;
		if($this->_data !== null)
			return $this->_data;
	}
	
	ob_start();
	$this->_display($v);
	$content = ob_get_clean();
	$this->cache_data($content, $v);
	
	return $content;
}

//子类实现具体的显示
function _display($v = null){echo $this->name;}

}