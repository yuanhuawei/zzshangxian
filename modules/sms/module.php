<?php
defined('PHP168_PATH') or die();

class P8_SMS extends P8_Module{

var $instance; //手机短信接口
var $interfaces;

function __construct(&$system, $name){
	$this->system = &$system;
	parent::__construct($name);
	
	$this->interfaces = &$this->CONFIG['interfaces'];
}

function P8_SMS(&$system, $name){
	$this->__construct($system, $name);
}

/**
 * 发送手机短信
 * @param $message {string} 短信内容
 * @param $interface {string} 接口名称
 * @return {bool} true成功,flase失败
 */
function send($send_to, $message, $interface = '', $callback = false){
	if(empty($send_to) || $message == '' || !preg_match("/^\\d{10,}\\d+$/", $send_to)){
		return false;
	}
	
	!$interface && $interface = $this->get_used_interface();
	$int = &$this->load_interface($interface);
	
	return $int?$int->send($send_to, $message):false;
}


function &load_interface($interface){
	$this->instance[$interface] = null;
	
	if(empty($this->instance[$interface])){
		if(!is_file($this->path .'interface/'. $interface .'/interface.php')){
			return null;
		}
		
		require_once $this->path .'interface/'. $interface .'/interface.php';
		
		$class = 'P8_SMS_'. $interface;
		$this->instance[$interface] = new $class($this, $this->interfaces[$interface]['config']);
		
		load_language($this, $interface);
	}
	
	return $this->instance[$interface];
}

function get_used_interface(){
	foreach($this->interfaces as $interface => $data){
		if($data['enabled'])return $interface;
	}
}

function callback_header($head){
	return '{[('. $head .')]}';
}

/**
* 手机短信的回复接口
* @param string $number 手机号码
* @param string $mes 回复消息
* @param string $sent_mes 己发送的消息
**/
function callback($number, $mes, $sent_mes = ''){
	$number = preg_replace('/[^\d]/', '', $number);
	
	// system/module-method-param1-param2
	if(preg_match('/\{\[\(([^\)]+?)\)\]\}/', $sent_mes, $m)){
		$tmp = explode('/', $m[1]);
		
		$system = $tmp[0];
		
		if(isset($tmp[1])){
			$tmp = explode('-', $tmp[1]);
			
			$module = array_shift($tmp);
			$method = array_shift($tmp);
			
			if(empty($module) || empty($method) || !get_module($system, $module)) return null;
			
			if($system == 'core'){
				$this_system = &$this->core;
			}else{
				$this_system = &$this->core->load_system($system);
			}
			
			$this_module = &$this_system->load_module($module);
			
			if(!method_exists($this_module, $method)) return null;
			
			return $this_module->$method($number, $mes, $tmp);
		}
	}
}

function set($data){}


function list_interface($refresh = false){
	
	if(!$refresh) return $this->CONFIG['interfaces'];
	
	$interfaces = array();
	
	$handle = opendir($this->path .'interface/');
	while(($item = readdir($handle)) !== false){
		if($item == '.' || $item == '..') continue;
		
		if(
			is_dir($this->path .'interface/'. $item) && is_file($this->path .'interface/'. $item .'/interface.php') &&
			($info = @include $this->path .'interface/'. $item .'/#.php')
		){
			
			$int = empty($this->CONFIG['interfaces'][$item]) ? array() : $this->CONFIG['interfaces'][$item];
			$config = empty($int['config']) ? array() : $int['config'];
			
			$interfaces[$item] = array(
				'alias' => $info['alias'],
				'apply_url' => $info['apply_url'],
				'enabled' => empty($int['enabled']) ? 0 : 1,
				'config' => array_merge($info['config'], $config)
			);
			
		}
	}
	
	$this->set_config(array('interfaces' => $interfaces));
	return $this->interfaces = $interfaces;
}

}