<?php
defined('PHP168_PATH') or die();

class P8_CMS_Model_Controller extends P8_Controller{

function __construct(&$obj){
	parent::__construct($obj);
	
}

function P8_CMS_Model_Controller(&$obj){
	$this->__construct($obj);
}

/**
* 添加一个模型
**/
function add(&$POST){
	
	$data = $this->valid_model_data($POST);
	
	if(!$this->check_model_name($data['name'])) return false;
	$addon = array();

	if(!empty($POST['frommodel']) && is_dir($this->model->system->path .'#export/'. $POST['frommodel'])){
		
		$mod_data = include $this->model->system->path .'#export/'. $POST['frommodel'] .'/#data.php';
		$addon = array('#fields' => $mod_data['#fields']);
	}
	return $this->model->add($data, $addon);
}

/**
* 修改一个模型
* @param string $name 模型名称
* @param array $POST 数据
**/
function update($name, &$POST){
	
	$data = $this->valid_model_data($POST);
	//模型名不允许修改
	unset($data['name']);
	
	return $this->model->update($name, $data);
}

/**
* 添加一个字段
* @param array $POST 数据
**/
function add_field(&$POST){
	$data = $this->valid_field_data($POST);
	
	if(!$this->check_field_name($data['model'], $data['name'])) return false;
	
	if(!isset($this->model->field_types[$data['type']])) return false;	//不允许的类型
	if(!isset($this->model->widgets[$data['widget']])) return false;	//不允许的类型
	
	return $this->model->add_field($data);
}

/**
* 修改一个字段
* @param int $id ID
* @param array $POST 数据
**/
function update_field($id, &$POST){
	$data = $this->valid_field_data($POST);
	
	if(!isset($this->model->field_types[$data['type']])) return false;	//不允许的类型
	if(!isset($this->model->widgets[$data['widget']])) return false;	//不允许的类型
	if($data['parent'] == $id) $data['parent'] = 0;
	
	return $this->model->update_field($id, $data);
}

/**
* 验证是否是正确的模型名,字段名,必须以字母开头
* @param string $name
**/
function valid_name($name){
	return preg_replace('/[^0-9a-zA-Z_]/', '', $name);
}

/**
* 验证模型数据
* @param array $POST
**/
function valid_model_data(&$POST){
	$data = array();
	$data['name'] = isset($POST['name']) ? $this->valid_name($POST['name']) : '';
	$data['alias'] = isset($POST['alias']) ? html_entities($POST['alias']) : '';
	$data['enabled'] = empty($POST['enabled']) ? false : true;
	$data['config'] = isset($POST['config']) && is_array($POST['config']) ? $POST['config'] : array();
	
	return $data;
}

/**
* 验证模型字段数据
* @param array $POST
**/
function valid_field_data(&$POST){
	
	$data = array();
	
	$data['type'] = isset($POST['type']) ? $POST['type'] : '';
	$data['widget'] = isset($POST['widget']) ? $POST['widget'] : '';
	$data['widget_addon_attr'] = isset($POST['widget_addon_attr']) ? $POST['widget_addon_attr'] : '';
	$data['model'] = isset($POST['model']) ? $this->valid_name($POST['model']) : '';
	$data['name'] = isset($POST['name']) ? $this->valid_name($POST['name']) : '';
	$data['parent'] = isset($POST['parent']) ? intval($POST['parent']) : 0;
	$data['alias'] = isset($POST['alias']) ? html_entities($POST['alias']) : '';
	$data['length'] = isset($POST['length']) ? preg_replace("/[^0-9,]/", '', $POST['length']) : 0;
	$data['is_unsigned'] = empty($POST['is_unsigned']) ? 0 : 1;
	$data['editable'] = empty($POST['editable']) ? 0 : 1;
	$data['not_null'] = empty($POST['not_null']) ? 0 : 1;
	$data['list_table'] = empty($POST['list_table']) ? 0 : 1;
	$data['filterable'] = empty($POST['filterable']) ? 0 : 1;
	$data['orderby'] = empty($POST['orderby']) ? 0 : 1;
	$data['default_value'] = isset($POST['default_value']) ? html_entities($POST['default_value']) : '';
	$data['units'] = isset($POST['units']) ? html_entities($POST['units']) : '';
	$data['description'] = isset($POST['description']) ? html_entities($POST['description']) : '';
	
	$data_key = isset($POST['data_key']) ? (array)$POST['data_key'] : array();
	$data_value = isset($POST['data_value']) ? (array)$POST['data_value'] : array();
	
	$data['data'] = array();
	foreach($data_key as $k => $v){
		if(!isset($data_value[$k])) continue;
		
		$data['data'][html_entities($v)] = html_entities($data_value[$k]);
	}
	
	$data['display_order'] = isset($POST['display_order']) ? intval($POST['display_order']) : 0;
	
	
	$data['config'] = isset($POST['config']) ? p8_stripslashes2((array)$POST['config']) : array();
	$fields = array_flip(array('id', 'config', 'type', 'widget', 'widget_addon_attr', 'model', 'name', 'alias', 'length', 'is_unsigned', 'not_null', 'list_table', 'filterable', 'orderby', 'default_value', 'data', 'display_order'));
	/*
	foreach($data['config'] as $k => $v){
		if(isset($fields)) unset($data[$k]);
	}*/
	
	unset($data_key, $data_value);
	
	return $data;
}

/**
* 删除模型
* @param string $name 模型名称
**/
function delete($name){
	
	if(empty($name)) return false;
	
	$cond = "name = '$name'";
	
	return $this->model->delete($cond);
}

/**
* 删除字段
* @param int $id 字段ID
**/
function delete_field($id){
	$id = filter_int($id);
	$ids = implode(',', $id);
	
	if(empty($ids)) return false;
	
	$cond = "id IN ($ids)";
	
	return $this->model->delete_field($cond);
}

/**
* 检查模型名称是不是合法的
* @param string $name 模型名称
* @return bool
**/
function check_model_name($name){
	
	if(!preg_match('/^[a-zA-z]/', $name) && preg_match('/[^0-9A-Za-z_]/', $name)){
		return false;
	}
	
	if(empty($name)) return false;
	
	//不能用以下的名称作为模型名称
	if(in_array($name, array('core', 'config', 'label', 'global', 'inc', 'call', 'admin', 'install', '#', 'acl', 'modules', 'model', 'widget', 'member', 'homepage', 'special', 'models'))) return false;
	
	//检查模型名是否有重复
	$tmp = $this->model->get_model($name);
	return empty($tmp);
}


/**
* 检查一个字段名是否合法
* @param int $mid 模型ID
* @param string $name 字段名称
* @return bool
**/
function check_field_name($model, $name){
	
	if(!preg_match('/^[a-zA-z]/', $name) && preg_match('/[^0-9A-Za-z_]/', $name)){
		return false;
	}
	
	if(empty($name)) return false;
	
	$tmp = $this->model->get_model($model);
	if(empty($tmp)) return false;
	
	//不能用以下的名称作为字段名称
	if(in_array($name, array('category', 'page', 'data', 'addon'))) return false;
	
	//检查字段是否重复
	$item = &$this->model->system->load_module('item');
	$item->set_model($model);
	
	//字段不能与两个数据表的重复
	$tmp = $this->DB_master->fetch_one("SHOW FIELDS FROM $item->table LIKE '$name'");
	if(!empty($tmp)){
		return false;
	}
	
	$tmp = $this->DB_master->fetch_one("SHOW FIELDS FROM $item->addon_table LIKE '$name'");
	if(!empty($tmp)){
		return false;
	}
	
	return true;
}

}