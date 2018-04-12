<?php
defined('PHP168_PATH') or die();

class P8_CMS extends P8_System{

var $_models;	//单个模型的数组
var $models;	//全部模型
var $model;		//当前模型
var $MODEL;		//当前模型名称
var $is_main_verifier;
var $is_category_verifier;
var $is_guest;
var $item_table;
var $category_table;
var $_category;
var $index_files;

function __construct(&$core, $name){
	$this->core = &$core;
	parent::__construct($name);
	
	$this->is_category_verifier = array();
	$this->is_main_verifier = false;
	$this->is_guest = false;
	$this->_models = $this->_category = array();
	$this->index_files = array(
		1 => 'index.html',
		2 => 'index.shtml',
		3 => 'index.htm',
	);
	
	$this->item_table = $this->TABLE_ .'item';
	$this->category_table = $this->TABLE_ .'category';
	
}

function P8_CMS(&$core, $name){
	$this->__construct($core, $name);
}

function init_model(){
	global $MODEL, $this_model, $this_module;
	
	$MODEL = isset($_REQUEST['model']) ? basename($_REQUEST['model']) : '';
	$this->model = &$this->get_model($MODEL);
	if(empty($this->model)) return null;
	
	$this_model = $this->model;
	
	$this_model['path'] = $this->path .'model/'. $MODEL .'/';
	
	if(isset($this_module) && $this_module->name == 'item'){
		$this_module->set_model($MODEL);
		//加载语言包
		load_language($this_module, $MODEL);
	}
	
}

/**
* 取得sphinx索引
**/
function sphinx_indexes($models = array(), $with_delta = false){
	$_models = $this->get_models();
	if(empty($models))
		$models = $_models;
	
	//拼凑所有模型的索引
	$indexes = $comma = '';
	foreach($models as $model => $v){
		if(!$_models[$model]['enabled']) continue;
		
		$indexes .= $comma . $this->core->CONFIG['sphinx_prefix'] . $this->name .'-item-'. $model .
			($with_delta ? '; delta_'. $this->core->CONFIG['sphinx_prefix'] . $this->name .'-item-'. $model : '');
		
		$comma = '; ';
	}
	return $indexes;
}

/**
* 取得模型信息
**/
function &get_model($name){
	if(isset($this->_models[$name])){
		return $this->_models[$name];
	}
	
	$this->_models[$name] = $this->core->CACHE->read($this->name .'/modules', 'model', $name, 'serialize');
	return $this->_models[$name];
}

/**
* 取得所有模型, 仅仅是全部模型的摘要,只包含ID和名称
**/
function get_models($enabled=0){
	if(empty($this->models)){
		
		$this->models = $this->core->CACHE->read($this->name .'/modules', 'model', 'models');
	}
	if(empty($this->models)){
		
		$Model = $this->load_module('model');
		$Model->cache();
		$this->models = $this->core->CACHE->read($this->name .'/modules', 'model', 'models');
	}
	if($enabled){
		$return = array();
		foreach($this->models as $mk=>$model){
			if($model['enabled']){
				$return[$mk] = $model;
			}
		}
		return $return;
	}
	return $this->models;
}

/**
* 
**/
function &fetch_category($id, $refresh = false){
	if(isset($this->_category[$id]) && !$refresh){
		return $this->_category[$id];
	}else{
		$this->_category[$id] = $this->core->CACHE->read($this->name .'/modules', 'category', (int)$id, 'serialize');
		return $this->_category[$id];
	}
}

}