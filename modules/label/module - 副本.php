<?php
defined('PHP168_PATH') or die();

/**
* 标签模块,在编译模板的时候已经将标签的功能编译上了,不用再调用
* $__label 储存标签的数据
* 标签缓存文件名结构 system(-)module(#)postfix(@)timestamp,括号部分为分隔符
**/

class P8_Label extends P8_Module{

var $table;			//数据表
var $scope;			//当前作用域
var $page;			//当前页面
var $_scopes;		//作用域数组
var $_data;			//标签数据
var $restore_data;	//备份被覆盖的数据
var $restore_label;	//备份被覆盖的数据
var $_labels;		//标签缓存,有作用域
var $expire_labels;	//过期的标签
var $missed_labels;	//没有命中的标签
var $var_labels;	//变量标签
var $last_postfix;	//最后一个后缀
var $last_cache;	//上一次更新缓存的时间,memcache无法批量删除数据,写缓存时加"@时间戳"后缀,每更新一次,丢弃上次的数据,以此后缀读写,使数据更新统一
var $_last_update;
var $ROLE;			//角色

function __construct(&$system, $name){
	//暂时定为不可设置
	$this->configurable = false;
	$this->system = &$system;
	
	parent::__construct($name);
	
	$this->table = $this->core->TABLE_ .'label';
	$this->last_cache = '@'. $this->core->CONFIG['last_label_cache'];
	$this->restore_label = $this->restore_data = $this->_labels = $this->_data = $this->var_labels = $this->_last_update = array();
	
	register_shutdown_function(array(&$this, 'last_update'));
}

function P8_Label(&$system, $name){
	$this->__construct($system, $name);
}

/**
* 初始化,初始化作用域,角色
**/
function init($SYSTEM, $MODULE, $PAGE, $SITENAME){
	
	//设置作用域
	if($MODULE){
		//作用域为模块
		$_scopes = array(
			'core',
			$SYSTEM,
			$SYSTEM .'-'. $MODULE			
		);
		if(!empty($SITENAME)){
			$_scopes[] = $SYSTEM .'='. $SITENAME;
			$_scopes[] = $SYSTEM .'-'. $MODULE .'='. $SITENAME;
		}
		$_scopes = array_unique($_scopes);
		
		$scope = $SYSTEM .'-'. $MODULE .'='. $SITENAME;
	}else if($SYSTEM != 'core'){
		//作用域为系统
		$_scopes = array(
			'core',
			$SYSTEM
		);
		if(!empty($SITENAME)){
			$_scopes[] = $SYSTEM.'='. $SITENAME;
		}	
		$scope = $SYSTEM;
	}else{
		//作用域为核心
		$_scopes = array('core');
		$scope = 'core';
	}
	
	//作用域相同,不用重复初始化
	//if($this->scope == $scope) return;
	
	$this->missed_labels = $this->expire_labels = array();
	$this->_scopes = $_scopes;
	$this->scope = $scope;
	
	$this->ROLE = $this->core->ROLE;
	$this->last_postfix = '';
	$this->page = $PAGE;
}


/**
* 设置标签后缀
**/
function postfix($postfix){
	if(empty($postfix) || !is_array($postfix)) return false;
	
	foreach($postfix as $name){
		$this->_scopes[] = $this->scope .'#'. $name;
		$this->last_postfix = $name;
	}
	
	$this->_scopes = array_unique($this->_scopes);
	
}

/**
* 显示标签数据,会检测标签的过期时间
* @param string $name 标签名称
* @param array $var 变量标签传入的变量
* 特殊参数
* #page#		页码
* #page_size#	每页记录数
* #count#		记录数
* #template#	模板
**/
function display($name, $var = null){
	
	$ret = $ssi = '';
	$hide = $missed = true;
	$var_cache = false;
	//是否是变量标签
	$var_label = func_num_args() == 2 ? true : false;
	
	if($var_label){
		//########## 变量标签 ##########
		
		$missed = false;
		
		//注销无关参数,并复制
		$_var = $var; unset($_var['#count#'], $_var['#template#']);
		$hash = md5($name . serialize($_var));
		unset($_var);
		
		$prefix = substr($hash, 0, 2);
		
		//检查有没有读取过缓存
		isset($this->var_labels[$hash]) || $data = $this->core->CACHE->read('label/data/var/', $prefix, $hash . $this->last_cache, 'serialize');
		
		//重新读缓存
		if(isset($data)){
			$this->var_labels[$hash] = $data;
		}
		
		//缓存为空或缓存过期
		if(empty($this->var_labels[$hash]) || P8_TIME > $this->var_labels[$hash]['expire']){
			$var_cache = true;
			//重新读标签
			if($data = $this->cache_var_label($name, $var, $hash)){
				$this->var_labels[$hash] = $data;
			}else{
				//此标签还没有添加或丢失?
				$ret = '';
				$this->var_labels[$hash] = array('content' => '', 'expire' => 9999999999);
			}
		}
		
		//检查权限
		if(empty($this->var_labels[$hash]['allowed_roles']) || isset($this->var_labels[$hash]['allowed_roles'][$this->ROLE])){
			$ret = $this->var_labels[$hash]['content'];
			$ssi = empty($this->var_labels[$hash]['ssi']) ? '' : $this->var_labels[$hash]['ssi'];
		}else{
			$ret = '';
		}
		
		if(isset($this->var_labels[$hash]['pages'])){
			global $__label;
			$__label[$name .'_pages'] = $this->var_labels[$hash]['pages'];
		}
		
		$hide = !empty($this->var_labels[$hash]['hide']);
		
		unset($data);
		
	}else{
		
		//########## 固定标签 ##########
		foreach($this->_data as $k => $v){
			if(isset($v[$name])){
				//检查权限
				if(
					empty($this->_data[$k][$name]['allowed_roles']) ||
					isset($this->_data[$k][$name]['allowed_roles'][$this->ROLE])
				){
					$ret = $this->_data[$k][$name]['content'];
					$ssi = empty($this->_data[$k][$name]['ssi']) ?
						'' :
						$this->_data[$k][$name]['ssi'];
				}else{
					$ret = '';
				}
				
				$missed = false;
				
				$hide = !empty($this->_data[$k][$name]['hide']);
				
				if(
					empty($this->expire_labels[$name]) &&
					P8_TIME > $v[$name]['expire']
				){
					//标签过期
					$this->expire_labels[$name] = 1;
				}
				
				break;
			}
		}
		
	}
	
	if($missed){
		//未命中的标签,如果是变量标签把变量存入,固定的存入1
		$this->missed_labels[$name] = $var_label ? $var : 1;
	}
	
	//如果是标签编辑状态,而且不是分页数据,添加标签占位,只有管理员才能看见标签
	if(P8_EDIT_LABEL && !defined('P8_GENERATE_HTML') ){
		$ret = $this->edit_mode($name) . $ret;
	}else if($hide){
		//隐藏
		$ret = '';
	}else if($ssi && defined('P8_GENERATE_HTML')){
		//生成静态才调用SSI
		$ret = $ssi;
	}
	
	return $ret;
}

/**
* 缓存变量标签
* @param string $name 标签名称
* @param array $v 标签接收的变量
* @param string $hash 哈希
**/
function cache_var_label($name, &$v, $hash){
	
	$label = $this->get($name);
	if(empty($label)) return false;
	
	$data = $this->fetch($label, $v);
	//$data = $this->fetch($label, $this->DB_slave->escape_string($v));
	
	//有分页信息
	global $__label;
	$__label[$name] = $data['content'];
	
	if($label['ttl'] > -1){
		//ttl小于0的时候变量标签不写缓存
		$prefix = substr($hash, 0, 2);
		
		if(!empty($label['option']['ssi'])){
			$ssi = CACHE_PATH .'label/ssi/var/'. $prefix .'/'. $hash .'@'. $label['postfix'] .'.html';
			
			md(CACHE_PATH .'label/ssi/var/'. $prefix .'/');
			write_file($ssi, $data['content'] ."\r\n");
			
			$data['ssi'] = '<!--#include virtual="'. P8_ROOT . str_replace(PHP168_PATH, '', $ssi) .'"-->';
		}
		
		$this->core->CACHE->write('label/data/var/', $prefix, $hash . $this->last_cache, $data, 'serialize');
		
	}
	
	return $data;
}

/**
* 获取一条标签,并返回其信息
**/
function get($name){
	$this->get_cache();
	
	$label = array();
	foreach($this->_labels as $scope => $v){
		if(isset($v[$name])){
			$label = $v[$name];
			break;
		}
	}
	
	return $label;
}

function parse_scope($scope){
	//system-module=site#postfix
	$tmp = explode('-', $scope);
	$ret = array(
		'system' => '',
		'module' => '',
		'site' => '',
		'postfix' => ''
	);
	if(isset($tmp[1])){
		//module
		$ret['system'] = $tmp[0];
		$_tmp = explode('=', $tmp[1]);
		
		if(isset($_tmp[1])){
			$ret['module'] = $_tmp[0];
			$__tmp = explode('#', $_tmp[1]);
			if(isset($__tmp[1])){
				//system-module=site#postfix
				$ret['site'] = $__tmp[0];
				$ret['postfix'] = $__tmp[1];
			}else{
				//system-module=site
				$ret['site'] = $_tmp[1];
			}
		}else{
			$_tmp = explode('#', $tmp[1]);
			if(isset($_tmp[1])){
				//system-module#postfix
				$ret['module'] = $_tmp[0];
				$ret['postfix'] = $_tmp[1];
			}else{
				//system-module
				$ret['module'] = $_tmp[0];
			}
		}
	}else{
		$_tmp = explode('=', $tmp[0]);
		if(isset($_tmp[1])){
			$ret['system'] = $_tmp[0];
			$__tmp = explode('#', $_tmp[1]);
			if(isset($__tmp[1])){
				//system=site#postfix
				$ret['site'] = $__tmp[0];
				$ret['postfix'] = $__tmp[1];
			}else{
				//system=site
				$ret['site'] = $_tmp[1];
			}
		}else{
			$_tmp = explode('#', $tmp[0]);
			if(isset($_tmp[1])){
				//system#postfix
				$ret['system'] = $_tmp[0];
				$ret['postfix'] = $_tmp[1];
			}else{
				//system
				$ret['system'] = $tmp[0];
			}
		}
	}
	
	return $ret;
}

/**
* 标签编辑模式
* @param string $name 标签名称
* @return string 标签编辑的代码
**/
function edit_mode($name){
	global $P8LANG, $RESOURCE;
	
	load_language($this, 'global');
	
	$label = $this->get($name);
	$bgcolor = empty($label['option']['bgcolor']) ? '#0000ff' : $label['option']['bgcolor'];
	$width = isset($label['option']['place_holder_width']) ? $label['option']['place_holder_width'] : 60;
	$height = isset($label['option']['place_holder_height']) ? $label['option']['place_holder_height'] : 20;
	
	$new_label = empty($label) ? true : false;
	
	return 
	'<div style="position: absolute; width: 0px; height: 0px;">'.
		'<div class="label" style="position: absolute; border: '. (empty($label['variable']) ? '1px' : '5px') .' solid #ff0000; z-index: 9999; background-color: #0000ff; color:#000; text-align: left; text-size:14px; text-weight: normal; '. ($new_label ? '' : 'filter: alpha(opacity=40); opacity: 0.4; ') .'width: '. $width .'px; height: '. $height .'px; background-color:'. $bgcolor.';" title="'. $P8LANG['label_name'] .': ['. $name .'] :'. ($new_label ? '' : $label['ttl']) .' '. $P8LANG['label_hover_hint'] .'"'. ($new_label ? '' : ' id="#label_'. $label['id'] .'"') .'>'. ($new_label ? $P8LANG['new_label'] .': ' : '') .
			'<span style="display: none;">'.$name.'</span>'.
			'<div style="position: absolute; width: 15px; height: 15px; background: url('. $RESOURCE .'/images/se-resize.png) no-repeat -8px -8px; right: 0px; bottom: 0px; clear: both;cursor:se-resize ;font-size:1px;line-height:0%;">&nbsp;</div>'.
		'</div>'.
	'</div>';
}

/**
* 读取标签缓存
**/
function get_cache(){
	
	//针对生成静态,暂时保存有后缀的标签
	foreach($this->_labels as $k => $v){
		if(strpos($k, '#') !== false){
			$this->restore_label[$k] = $this->_labels[$k];
			unset($this->_labels[$k]);
		}
	}
	
	foreach($this->_scopes as $v){
		//针对生成静态,还原有后缀的标签
		if(isset($this->restore_label[$v])){
			$this->_labels = array_merge(
				array($v => $this->restore_label[$v]),
				$this->_labels
			);
			unset($this->restore_label[$v]);
		}
		
		if(isset($this->_labels[$v])) continue;
		
		$tmp = $this->parse_scope($v);
		$this->_labels = array_merge(
			array($v => $this->core->CACHE->read('label/#/'. $tmp['system'], $tmp['module'], $tmp['site'].$tmp['postfix'] . $this->last_cache, 'serialize')),
			$this->_labels
		);
		
	}
	
	return true;
}

/**
* 取得标签数据缓存
**/
function get_data_cache(){
	
	//针对生成静态,暂时保存有后缀的标签
	foreach($this->_data as $k => $v){
		if(strpos($k, '#') !== false){
			$this->restore_data[$k] = $this->_data[$k];
			unset($this->_data[$k]);
		}
	}

	$empty = array();
	foreach($this->_scopes as $v){
		//针对生成静态,还原有后缀的标签
		if(isset($this->restore_data[$v])){
			$this->_data = array_merge(
				array($v => $this->restore_data[$v]),
				$this->_data
			);
			unset($this->restore_data[$v]);
		}
		
		if(isset($this->_data[$v])) continue;
		
		$tmp = $this->parse_scope($v);
		$this->_data = array_merge(
			array($v => $this->core->CACHE->read('label/data/'. $tmp['system'], $tmp['module'], $tmp['site'] . $tmp['postfix'] . $this->last_cache, 'serialize')),
			$this->_data
		);
		
		if(empty($this->_data[$v])){
			$empty[$v] = 1;
		}else{
			
		}
	}

	//如果缓存为空,重新生成
	if($empty) $this->cache_data($empty);
}

/**
* 根据标签获得标签数据
* @param array $label 一个标签记录,包含标签的所有信息
* @return string 标签内容数据
* 注意!包含模板的时候由于变量作用域是在函数里面,因此模板里的变量要特别注意
**/
function fetch(&$label, $var = null){
	
	global $core, $this_system, $SKIN, $RESOURCE;
	//随机数
	$rand = rand_str(4);
	
	$_SKIN = $SKIN;
	/*if($label['type'] != 'module_data' && defined('P8_ADMIN')){
		if($label['system'] == 'core'){
			$system = &$core;
		}else{
			$system = &$this->core->load_system($label['system']);
		}
		$SKIN = $system->skin($label['page']);
	}*/
	
	switch($label['type']){
	
	/****** {HTML类型的标签 start*******/
	case 'html':
		
		$tpl = $this->compile_template('<!--{php168}-->'. $label['content'] .'<!--{/php168}-->');
		ob_start(); eval($tpl); $content = ob_get_clean();
		unset($tpl);
	break;
	/****** HTML类型的标签} end*******/
	
	/****** {模块数据类型的标签 start*******/
	case 'module_data':
		
		//加载标签所调用的模块,不要再出现global $this_system, $this_module;
		if($label['source_system'] == 'core'){
			$this_system = &$core;
			if(empty($core->modules[$label['source_module']])){
				$content = '';
				break;
			}
			
			$this_module = &$this->core->load_module($label['source_module']);
		}else{
			if(!get_module($label['source_system'], $label['source_module'])){
				$content = '';
				break;
			}
			
			$this_system = &$this->core->load_system($label['source_system']);
			$this_module = &$this_system->load_module($label['source_module']);
		}
		
		//自己定义的标签函数,默认是label
		$method = empty($label['option']['method']) ? 'label' : $label['option']['method'];
		$data = method_exists($this_module, $method) ?
			$this_module->$method($this, $label, $var) :
			array('');
		
		/*$data = call_user_func_array(
			array(&$this_module, empty($label['option']['method']) ? 'label' : $label['option']['method']),
			array(&$this, &$label, &$var)
		);*/
		
		$content = $data[0];
		
		isset($data[1]) && $pages = $data[1];
		unset($data);
	break;
	/****** 模块数据类型的标签 end}*******/
	
	/****** SQL类型的标签 start{*******/
	case 'sql':
		$list = $this->DB_slave->fetch_all($label['content']);
		
		if(!empty($label['option']['tplcode'])){
			$tplcode = $this->compile_template($label['option']['tplcode']);
			ob_start();
			eval($tplcode);
			$content = ob_get_clean();
			unset($tplcode);
		}else{
			ob_start();
			include $this->template($label['option']['template']);
			$content = ob_get_clean();
		}
	break;
	/****** SQL类型的标签 end}*******/
	
	
	
	/****** 图片类型的标签 start{*******/
	case 'image':
		ob_start(); eval($this->compile_template('<!--{php168}-->'. $label['option']['image']['url'] .'<!--{/php168}-->')); $imgurl = ob_get_clean();
		$imgurl = $imgurl? $imgurl: $label['option']['image']['url'];
		$content = '<a href="'. $imgurl .'" target="_blank" title="'. $label['option']['image']['title'] .'" style="text-decoration:none;">'.
			'<img width="' . $label['option']['width'] .'" height="'. $label['option']['height'] .'" border="none" alt="'. $label['option']['image']['title'] .'" src="'. $label['option']['image']['name'] .'" />'.
		'</a>';
		/*ob_start();
		include $this->template($label['option']['template']);
		$content = ob_get_clean();*/
	break;
	/****** 图片类型的标签 end}*******/
	
	/****** FLASH类型的标签 start{*******/
	case 'flash':
		$width = intval($label['option']['width']) == 0 ? 330 : $label['option']['width'];
		$height = intval($label['option']['height']) == 0 ? 260 : $label['option']['height'];
		
		ob_start(); eval($this->compile_template('<!--{php168}-->'. $label['option']['flash']['url'] .'<!--{/php168}-->')); $flashurl = ob_get_clean();
		$flashurl = $flashurl? $flashurl: $label['option']['flash']['url'];
		
		$content = '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="'. $width .'" height="'. $height .'">
		<param name="allowScriptAccess" value="sameDomain" />
		<param name="movie" value="'. $flashurl .'" />
		<param name="quality" value="high" />
		<param name="wmode" value="transparent" />
		<param name="scale" value="noscale" />
		<embed wmode="transparent" src="'. $flashurl .'" quality="high" bgcolor="#ffffff" width="'. $width .'" height="'. $height .'" name="var" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" /></object>';
	break;
	/****** FLASH类型的标签 end}*******/
	
	
	
	/****** slide类型的标签 start{*******/
	case 'slide':
	
		$images = empty($label['option']['images']) ? array() : $label['option']['images'];
		//幻灯片宽高
		$swidth = isset($label['option']['width']) ? $label['option']['width'] : 300;
		$sheight = isset($label['option']['height']) ? $label['option']['height'] : 300;
		$list = array();
		foreach($images['title'] as $k => $v){
			$list[$k]['title'] = $images['title'][$k];
			
			$list[$k]['frame'] = $images['src'][$k];
			
			ob_start(); eval($this->compile_template('<!--{php168}-->'. $images['url'][$k] .'<!--{/php168}-->')); $listurl = ob_get_clean();
			$list[$k]['url'] = $listurl? $listurl: $images['url'][$k];
		}
		
		if(!empty($label['option']['tplcode'])){
			include_once PHP168_PATH.'inc/template.func.php';
			
			$tplcode = $this->compile_template($label['option']['tplcode']);
			ob_start();
			eval($tplcode);
			$content = ob_get_clean();
		}else{
			ob_start();
			include $this->template($label['option']['template']);
			$content = ob_get_clean();
		}
	break;
	/****** slide类型的标签 end}*******/
	
	//默认直接返回数据
	default:
		$content = $label['content'];
	}
	
	//设置标签下次过期时间
	$ret = array(
		//隐藏
		'hide' => empty($label['option']['hide']) ? false : true,
		//标签内容
		'content' => $content,
		//标签过期时间
		'expire' => $label['ttl'] ? P8_TIME + $label['ttl'] : 9999999999,
		//允许查看标签的角色
		'allowed_roles' => $label['option']['allowed_roles']
	);
	
	if(!empty($label['option']['ssi']) && $var === null){
		//静态标签的SSI
		md(CACHE_PATH .'label/ssi/'. $label['system'] .'/'. $label['module'] .'/', true);
		$ssi = CACHE_PATH .'label/ssi/'. $label['system'] .'/'. $label['module'] .'/'. $label['id'] .'@'. $label['postfix'] .'.html';
		
		write_file($ssi, $content ."\r\n");
		@chmod($ssi, 0644);
		$ret['ssi'] = '<!--#include virtual="'. P8_ROOT . str_replace(PHP168_PATH, '', $ssi) .'"-->';
	}
	
	if(isset($pages)){
		global $__label;
		$ret['pages'] = $__label = $pages;
	}
	
	$this->_last_update[$label['id']] = 1;
	
	$SKIN = $_SKIN;
	
	return $ret;
}

/**
* 生成指定作用域的标签数据缓存,在标签输出之前
* @param array $label_scopes 要缓存的标签域
**/
function cache_data($label_scopes = array()){
	
	if($lock = $this->core->CACHE->read('', 'label', 'cache_data_lock', 'serialize')){
		foreach($label_scopes as $scope => $v){
			if(isset($lock[$scope])){
				unset($label_scopes[$scope]);
			}else{
				$lock[$scope] = 1;
			}
		}
	}else{
		$lock = array();
	}
	
	if(empty($label_scopes)) return;
	
	//加锁,防止并发缓存多次
	$this->core->CACHE->write('', 'label', 'cache_data_lock', $lock, 'serialize');
	
	include $this->path .'call/cache_data.call.php';
}

/**
* 刷新过期和未命中的标签数据,不用手工调用,在标签输出之后
**/
function refresh_labels(){
	
	//如果没有标签可刷直接返回
	if(empty($this->expire_labels) && empty($this->missed_labels)) return false;
	
	//检查锁定
	$lock = $this->core->CACHE->read('', 'label', 'refresh_lock', 'serialize');
	
	foreach($this->_scopes as $v){
		if(!isset($lock[$v])){
			$lock[$v] = 1;
		}
	}
	
	if(empty($lock)) return false;
	
	$this->core->CACHE->write('', 'label', 'refresh_lock', $lock, 'serialize');
	
	include $this->path .'call/refresh_labels.call.php';
	
	return true;
}

/**
* 生成标签缓存
* @param int $id 仅生成指定ID的标签
* @param array $orig_data 原始数据
**/
function cache($id = 0, $orig_data = array()){
	parent::cache();
	
	include $this->path .'call/cache.call.php';
}

/**
* 编译标签模板
* @param string $name 模板的名称,可以带一层路径如path/name
**/
function template($name){
	$file = CACHE_PATH .'template/label/'. $name .'.php';
	if(
		!is_file($file) || 
		filemtime(TEMPLATE_PATH .'label/'. $name .'.html') > filemtime($file)
	){
		include_once PHP168_PATH .'inc/template.func.php';
		
		return template_cache('label/', '', $name);
	}
	
	return $file;
}

function compile_template($tpl){
	require_once PHP168_PATH .'inc/template.func.php';
	
	$tpl = template_compile($tpl);
	$tpl = str_replace(array('<?php', '?>'), array('', ''), $tpl);
	//$tpl = stripslashes($tpl);
	
	return $tpl;
}




















/**
* 添加标签
* @param array $data 
* @param string $replace 是否覆盖之前的 
**/
function add($data, $replace=false){
	$attachment_hash = $data['attachment_hash']; unset($data['attachment_hash']);
	
	$data['timestamp'] = P8_TIME;
	$data['option'] = $this->DB_master->escape_string(serialize(attachment_url($data['option'], true)));
	$data['content'] = $this->DB_master->escape_string(attachment_url($data['content'], true));
	
	if(
		$id = $this->DB_master->insert(
			$this->table,
			$data,
			array('return_id' => true,'replace'=>$replace)
		)
	){
		uploaded_attachments($this, $id, $attachment_hash);
		
		$this->cache($id);
	}
	return $id;
}

/**
* 更新标签
* @param int $id 标签ID
* @param array $data 
**/
function update($id, &$data){
	
	$orig_data = $this->view($id);
	$attachment_hash = $data['attachment_hash']; unset($data['attachment_hash']);
	
	$data['option'] = $this->DB_master->escape_string(serialize(attachment_url($data['option'], true)));
	$data['content'] = $this->DB_master->escape_string(attachment_url($data['content'], true));
	
	$status = $this->DB_master->update(
		$this->table,
		$data,
		"id = '$id'"
	);
	
	if($orig_data){
		uploaded_attachments($this, $id, $attachment_hash);
		
		//重新生成缓存
		$this->cache($id, $orig_data);
	}
	return $status;
}

/**
* 删除标签
* @param array $data 删除条件
**/
function delete($data){
	return include $this->path .'call/delete.call.php';
}

/**
* 取得一条标签
**/
function view($id){
	$data = $this->DB_master->fetch_one("SELECT * FROM $this->table WHERE id = '$id'");
	if(empty($data)) return array();
	
	$data['option'] = attachment_url(mb_unserialize($data['option']));
	$data['content'] = attachment_url($data['content']);
	return $data;
}

/**
* 更新标签上次更新时间
**/
function last_update(){
	if(empty($this->_last_update)) return;
	
	$ids = $comma = '';
	foreach($this->_last_update as $k => $v){
		$ids .= $comma . $k; $comma = ',';
	}
	
	$this->DB_master->update($this->table, array('last_update' => P8_TIME), 'id IN('. $ids .')');
}

}