<?php
defined('PHP168_PATH') or die();

class P8_Role_Controller extends P8_Controller{

function __construct(&$obj){
	parent::__construct($obj);
}

function P8_Role_Controller(&$obj){
	$this->__construct($obj);
}

function add(&$POST){
	$data = $this->valid_data($POST);
	
	return $this->model->add($data);
}

function update($id, &$POST){
	$data = $this->valid_data($POST);
	
	return $this->model->update($id, $data);
}

function add_group(&$POST){
	$data = $this->valid_group_data($POST);
	
	return $this->model->add_group($data);
}

function update_group($id, &$POST){
	$data = $this->valid_group_data($POST);
	
	return $this->model->update_group($id, $data);
}

function check_group_field_name($gid, $name){
	if(preg_match('/[^0-9A-Za-z_]/', $name)){
		return false;
	}
	
	$tmp = $this->DB_master->fetch_one("SHOW FIELDS FROM {$this->core->member_table} LIKE '$name'");
	if(!empty($tmp)){
		return false;
	}
	
	$tmp = $this->DB_master->fetch_one("SHOW FIELDS FROM {$this->model->TABLE_}group_{$gid}_data LIKE '$name'");
	if(!empty($tmp)){
		return false;
	}
	return true;
}

function valid_data(&$POST){
	$data = array();
	
	$data['system'] = isset($POST['system']) && get_system($POST['system']) ? $POST['system'] : 'core';
	$data['name'] = isset($POST['name']) ? html_entities($POST['name']) : '';
	$data['type'] = isset($POST['name']) && $POST['type'] == 'system' ? 'system' : 'normal';
	$data['gid'] = isset($POST['gid']) ? intval($POST['gid']) : 0;
	
	return $data;
}

function valid_group_data(&$POST){
	$data = array();
	
	$data['name'] = isset($POST['name']) ? html_entities($POST['name']) : '';
	$data['registrable'] = empty($POST['registrable']) ? 0 : 1;
	$data['default_role'] = isset($POST['default_role']) ? intval($POST['default_role']) : 0;
	$data['description'] = isset($POST['description']) ? html_entities($POST['description']) : '';
	
	return $data;
}

function add_group_field(&$POST){
	$data = $this->valid_group_field_data($POST);
	
	if(!$this->check_group_field($data['gid'], $data['name'])) return false;
	
	if(!isset($this->model->group_field_types[$data['type']])) return false;	//不允许的类型
	if(!isset($this->model->widgets[$data['widget']])) return false;	//不允许的类型
	
	return $this->model->add_group_field($data);
}

function update_group_field($id, &$POST){
	$data = $this->valid_group_field_data($POST);
	
	if(!isset($this->model->group_field_types[$data['type']])) return false;	//不允许的类型
	if(!isset($this->model->widgets[$data['widget']])) return false;	//不允许的类型
	
	return $this->model->update_group_field($id, $data);
}

function valid_group_field_data(&$POST){
	
	$data = array();
	
	$data['gid'] = isset($POST['gid']) ? intval($POST['gid']) : 0;
	$data['name'] = isset($POST['name']) ? $POST['name'] : '';
	$data['type'] = isset($POST['type']) ? $POST['type'] : '';
	$data['widget'] = isset($POST['widget']) ? $POST['widget'] : '';
	$data['widget_addon_attr'] = isset($POST['widget_addon_attr']) ? $POST['widget_addon_attr'] : '';
	$data['alias'] = isset($POST['alias']) ? html_entities($POST['alias']) : '';
	$data['length'] = isset($POST['length']) ? preg_replace("/[^0-9,]/", '', $POST['length']) : 0;
	$data['is_unsigned'] = empty($POST['is_unsigned']) ? 0 : 1;
	$data['not_null'] = empty($POST['not_null']) ? 0 : 1;
	$data['default_value'] = isset($POST['default_value']) ? html_entities($POST['default_value']) : '';
	
	$data_key = isset($POST['data_key']) ? html_entities($POST['data_key']) : array();
	$data_value = isset($POST['data_value']) ? html_entities($POST['data_value']) : array();
	$data['data'] = count($data_key) > 1 && count($data_value) > 1 ? serialize(array_combine($data_key, $data_value)) : '';
	
	$data['display_order'] = isset($POST['display_order']) ? intval($POST['display_order']) : 0;
	
	return $data;
}

function check_group_field($gid, $name){
	if(preg_match('/[^0-9a-zA-Z_]/', $name)){
		return false;
	}
	
	$tmp = $this->DB_master->fetch_one("SHOW FIELDS FROM {$this->model->TABLE_}group_{$gid}_data LIKE '$name'");
	return empty($tmp);
}

/**
* 设置权限
* @param object $obj 模型层对象
* @param int $role_id 角色ID
* @param array $acl 权限
* @param string $postfix 后缀
**/
function set_acl(&$obj, $role_id, $acl, $postfix = ''){
	
	if(empty($role_id)) return false;
	
	$acl['admin_actions'] = empty($acl['admin_actions']) ? array() : $acl['admin_actions'];
	$acl['actions'] = empty($acl['actions']) ? array() : $acl['actions'];
	
	switch($obj->type){
	
	case 'core':
	case 'system':
		$system = $obj->name;
		$module = '';
	break;
	
	case 'module':
		$system = $obj->system->name;
		$module = $obj->name;
	break;
	
	}
	
	$info = include $obj->path .'#.php';
	
	$postfix = preg_replace("/[^0-9a-zA-Z_]/", '', $postfix);
	
	return $this->model->set_acl($system, $module, $role_id, $acl, $info, $postfix);
}

}