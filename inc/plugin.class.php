<?php
defined('PHP168_PATH') or die();

/** ���,��ģ����� $plugin[�������] �Ϳ��Ե��ò���� **/
class P8_Plugin{

var $type;					//��������
var $core;					//���ĵ�����
var $CONFIG;				//����
var $name;					//�������
var $path;					//���·��
var $TABLE_;				//����ǰ׺
var $configurable = true;	//������?
var $_data;
var $_var_data;
var $url;					//���URL
var $controller;			//������
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
		//��������
		$this->CONFIG = $this->get_config();
	}
	
	$this->DB_master = &$this->core->DB_master;
	$this->DB_slave = &$this->core->DB_slave;
	
	//�������԰�
	load_language($this->core, 'plugin/'. $this->name .'/global');
}

function P8_Plugin($name){
	$this->__construct($name);
}

/**
* �������
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
* ��ȡ�������
* @param bool $cache �Ƿ�ӻ��������ȡ����,��������ݿ����ȡ
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
* д������Ļ���
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
* ��ȡģ��
* @param string $template ģ������,·������ڵ�ǰ�����Ŀ¼/template/plugin/$this->name/$template
* @return string ���ر���õ�ģ��·��
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
* ���漺��ʾ������
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
* �����ʾ����,ͨ���˺�����ʾ���������
* @param array $v ���ڻ�ȡҳ���ϱ���������
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

//����ʵ�־������ʾ
function _display($v = null){echo $this->name;}

}