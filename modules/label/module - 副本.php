<?php
defined('PHP168_PATH') or die();

/**
* ��ǩģ��,�ڱ���ģ���ʱ���Ѿ�����ǩ�Ĺ��ܱ�������,�����ٵ���
* $__label �����ǩ������
* ��ǩ�����ļ����ṹ system(-)module(#)postfix(@)timestamp,���Ų���Ϊ�ָ���
**/

class P8_Label extends P8_Module{

var $table;			//���ݱ�
var $scope;			//��ǰ������
var $page;			//��ǰҳ��
var $_scopes;		//����������
var $_data;			//��ǩ����
var $restore_data;	//���ݱ����ǵ�����
var $restore_label;	//���ݱ����ǵ�����
var $_labels;		//��ǩ����,��������
var $expire_labels;	//���ڵı�ǩ
var $missed_labels;	//û�����еı�ǩ
var $var_labels;	//������ǩ
var $last_postfix;	//���һ����׺
var $last_cache;	//��һ�θ��»����ʱ��,memcache�޷�����ɾ������,д����ʱ��"@ʱ���"��׺,ÿ����һ��,�����ϴε�����,�Դ˺�׺��д,ʹ���ݸ���ͳһ
var $_last_update;
var $ROLE;			//��ɫ

function __construct(&$system, $name){
	//��ʱ��Ϊ��������
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
* ��ʼ��,��ʼ��������,��ɫ
**/
function init($SYSTEM, $MODULE, $PAGE, $SITENAME){
	
	//����������
	if($MODULE){
		//������Ϊģ��
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
		//������Ϊϵͳ
		$_scopes = array(
			'core',
			$SYSTEM
		);
		if(!empty($SITENAME)){
			$_scopes[] = $SYSTEM.'='. $SITENAME;
		}	
		$scope = $SYSTEM;
	}else{
		//������Ϊ����
		$_scopes = array('core');
		$scope = 'core';
	}
	
	//��������ͬ,�����ظ���ʼ��
	//if($this->scope == $scope) return;
	
	$this->missed_labels = $this->expire_labels = array();
	$this->_scopes = $_scopes;
	$this->scope = $scope;
	
	$this->ROLE = $this->core->ROLE;
	$this->last_postfix = '';
	$this->page = $PAGE;
}


/**
* ���ñ�ǩ��׺
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
* ��ʾ��ǩ����,�����ǩ�Ĺ���ʱ��
* @param string $name ��ǩ����
* @param array $var ������ǩ����ı���
* �������
* #page#		ҳ��
* #page_size#	ÿҳ��¼��
* #count#		��¼��
* #template#	ģ��
**/
function display($name, $var = null){
	
	$ret = $ssi = '';
	$hide = $missed = true;
	$var_cache = false;
	//�Ƿ��Ǳ�����ǩ
	$var_label = func_num_args() == 2 ? true : false;
	
	if($var_label){
		//########## ������ǩ ##########
		
		$missed = false;
		
		//ע���޹ز���,������
		$_var = $var; unset($_var['#count#'], $_var['#template#']);
		$hash = md5($name . serialize($_var));
		unset($_var);
		
		$prefix = substr($hash, 0, 2);
		
		//�����û�ж�ȡ������
		isset($this->var_labels[$hash]) || $data = $this->core->CACHE->read('label/data/var/', $prefix, $hash . $this->last_cache, 'serialize');
		
		//���¶�����
		if(isset($data)){
			$this->var_labels[$hash] = $data;
		}
		
		//����Ϊ�ջ򻺴����
		if(empty($this->var_labels[$hash]) || P8_TIME > $this->var_labels[$hash]['expire']){
			$var_cache = true;
			//���¶���ǩ
			if($data = $this->cache_var_label($name, $var, $hash)){
				$this->var_labels[$hash] = $data;
			}else{
				//�˱�ǩ��û����ӻ�ʧ?
				$ret = '';
				$this->var_labels[$hash] = array('content' => '', 'expire' => 9999999999);
			}
		}
		
		//���Ȩ��
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
		
		//########## �̶���ǩ ##########
		foreach($this->_data as $k => $v){
			if(isset($v[$name])){
				//���Ȩ��
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
					//��ǩ����
					$this->expire_labels[$name] = 1;
				}
				
				break;
			}
		}
		
	}
	
	if($missed){
		//δ���еı�ǩ,����Ǳ�����ǩ�ѱ�������,�̶��Ĵ���1
		$this->missed_labels[$name] = $var_label ? $var : 1;
	}
	
	//����Ǳ�ǩ�༭״̬,���Ҳ��Ƿ�ҳ����,��ӱ�ǩռλ,ֻ�й���Ա���ܿ�����ǩ
	if(P8_EDIT_LABEL && !defined('P8_GENERATE_HTML') ){
		$ret = $this->edit_mode($name) . $ret;
	}else if($hide){
		//����
		$ret = '';
	}else if($ssi && defined('P8_GENERATE_HTML')){
		//���ɾ�̬�ŵ���SSI
		$ret = $ssi;
	}
	
	return $ret;
}

/**
* ���������ǩ
* @param string $name ��ǩ����
* @param array $v ��ǩ���յı���
* @param string $hash ��ϣ
**/
function cache_var_label($name, &$v, $hash){
	
	$label = $this->get($name);
	if(empty($label)) return false;
	
	$data = $this->fetch($label, $v);
	//$data = $this->fetch($label, $this->DB_slave->escape_string($v));
	
	//�з�ҳ��Ϣ
	global $__label;
	$__label[$name] = $data['content'];
	
	if($label['ttl'] > -1){
		//ttlС��0��ʱ�������ǩ��д����
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
* ��ȡһ����ǩ,����������Ϣ
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
* ��ǩ�༭ģʽ
* @param string $name ��ǩ����
* @return string ��ǩ�༭�Ĵ���
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
* ��ȡ��ǩ����
**/
function get_cache(){
	
	//������ɾ�̬,��ʱ�����к�׺�ı�ǩ
	foreach($this->_labels as $k => $v){
		if(strpos($k, '#') !== false){
			$this->restore_label[$k] = $this->_labels[$k];
			unset($this->_labels[$k]);
		}
	}
	
	foreach($this->_scopes as $v){
		//������ɾ�̬,��ԭ�к�׺�ı�ǩ
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
* ȡ�ñ�ǩ���ݻ���
**/
function get_data_cache(){
	
	//������ɾ�̬,��ʱ�����к�׺�ı�ǩ
	foreach($this->_data as $k => $v){
		if(strpos($k, '#') !== false){
			$this->restore_data[$k] = $this->_data[$k];
			unset($this->_data[$k]);
		}
	}

	$empty = array();
	foreach($this->_scopes as $v){
		//������ɾ�̬,��ԭ�к�׺�ı�ǩ
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

	//�������Ϊ��,��������
	if($empty) $this->cache_data($empty);
}

/**
* ���ݱ�ǩ��ñ�ǩ����
* @param array $label һ����ǩ��¼,������ǩ��������Ϣ
* @return string ��ǩ��������
* ע��!����ģ���ʱ�����ڱ������������ں�������,���ģ����ı���Ҫ�ر�ע��
**/
function fetch(&$label, $var = null){
	
	global $core, $this_system, $SKIN, $RESOURCE;
	//�����
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
	
	/****** {HTML���͵ı�ǩ start*******/
	case 'html':
		
		$tpl = $this->compile_template('<!--{php168}-->'. $label['content'] .'<!--{/php168}-->');
		ob_start(); eval($tpl); $content = ob_get_clean();
		unset($tpl);
	break;
	/****** HTML���͵ı�ǩ} end*******/
	
	/****** {ģ���������͵ı�ǩ start*******/
	case 'module_data':
		
		//���ر�ǩ�����õ�ģ��,��Ҫ�ٳ���global $this_system, $this_module;
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
		
		//�Լ�����ı�ǩ����,Ĭ����label
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
	/****** ģ���������͵ı�ǩ end}*******/
	
	/****** SQL���͵ı�ǩ start{*******/
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
	/****** SQL���͵ı�ǩ end}*******/
	
	
	
	/****** ͼƬ���͵ı�ǩ start{*******/
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
	/****** ͼƬ���͵ı�ǩ end}*******/
	
	/****** FLASH���͵ı�ǩ start{*******/
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
	/****** FLASH���͵ı�ǩ end}*******/
	
	
	
	/****** slide���͵ı�ǩ start{*******/
	case 'slide':
	
		$images = empty($label['option']['images']) ? array() : $label['option']['images'];
		//�õ�Ƭ���
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
	/****** slide���͵ı�ǩ end}*******/
	
	//Ĭ��ֱ�ӷ�������
	default:
		$content = $label['content'];
	}
	
	//���ñ�ǩ�´ι���ʱ��
	$ret = array(
		//����
		'hide' => empty($label['option']['hide']) ? false : true,
		//��ǩ����
		'content' => $content,
		//��ǩ����ʱ��
		'expire' => $label['ttl'] ? P8_TIME + $label['ttl'] : 9999999999,
		//����鿴��ǩ�Ľ�ɫ
		'allowed_roles' => $label['option']['allowed_roles']
	);
	
	if(!empty($label['option']['ssi']) && $var === null){
		//��̬��ǩ��SSI
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
* ����ָ��������ı�ǩ���ݻ���,�ڱ�ǩ���֮ǰ
* @param array $label_scopes Ҫ����ı�ǩ��
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
	
	//����,��ֹ����������
	$this->core->CACHE->write('', 'label', 'cache_data_lock', $lock, 'serialize');
	
	include $this->path .'call/cache_data.call.php';
}

/**
* ˢ�¹��ں�δ���еı�ǩ����,�����ֹ�����,�ڱ�ǩ���֮��
**/
function refresh_labels(){
	
	//���û�б�ǩ��ˢֱ�ӷ���
	if(empty($this->expire_labels) && empty($this->missed_labels)) return false;
	
	//�������
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
* ���ɱ�ǩ����
* @param int $id ������ָ��ID�ı�ǩ
* @param array $orig_data ԭʼ����
**/
function cache($id = 0, $orig_data = array()){
	parent::cache();
	
	include $this->path .'call/cache.call.php';
}

/**
* �����ǩģ��
* @param string $name ģ�������,���Դ�һ��·����path/name
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
* ��ӱ�ǩ
* @param array $data 
* @param string $replace �Ƿ񸲸�֮ǰ�� 
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
* ���±�ǩ
* @param int $id ��ǩID
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
		
		//�������ɻ���
		$this->cache($id, $orig_data);
	}
	return $status;
}

/**
* ɾ����ǩ
* @param array $data ɾ������
**/
function delete($data){
	return include $this->path .'call/delete.call.php';
}

/**
* ȡ��һ����ǩ
**/
function view($id){
	$data = $this->DB_master->fetch_one("SELECT * FROM $this->table WHERE id = '$id'");
	if(empty($data)) return array();
	
	$data['option'] = attachment_url(mb_unserialize($data['option']));
	$data['content'] = attachment_url($data['content']);
	return $data;
}

/**
* ���±�ǩ�ϴθ���ʱ��
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