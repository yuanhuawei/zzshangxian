<?php
defined('PHP168_PATH') or die();

class P8_Credit_Controller extends P8_Controller{

function __construct(&$obj){
	parent::__construct($obj);
	
}

function P8_Credit_Controller(&$obj){
	$this->__construct($obj);
}

function add(&$POST){
	$data = $this->valid_type_data($POST);
	$data['roe'] = $this->DB_master->escape_string(serialize($data['roe']));
	
	return $this->model->add($data);
}

function update($id, &$POST){
	$data = $this->valid_type_data($POST);
	unset($data['roe'][$id]);
	$data['roe'] = $this->DB_master->escape_string(serialize($data['roe']));
	//不能添加本身的汇率
	
	return $this->model->update($id, $data);
}

function valid_type_data(&$POST){
	$data = array();
	$data['name'] = isset($POST['name']) ? html_entities($POST['name']) : '';
	$data['unit'] = isset($POST['unit']) ? html_entities($POST['unit']) : '';
	$data['is_unsigned'] = empty($POST['is_unsigned']) ? 0 : 1;
	$data['float_bit'] = isset($POST['float_bit']) ? intval($POST['float_bit']) : 0;
	$data['default_value'] = isset($POST['default_value']) ? 
		(empty($POST['float_bit']) ? intval($POST['default_value']) : floatval($POST['default_value'])) : 
		0;
	$data['float_point'] = isset($POST['float_point']) ? intval($POST['float_point']) : 0;
	$data['roe'] = array();
	if(isset($POST['roe']) && is_array($POST['roe'])){
		foreach($POST['roe'] as $credit_id => $rate){
			$credit_id = intval($credit_id);
			$rate = (float)$rate;
			if(!$credit_id) continue;
			if($rate === 0.0) continue;
			
			$data['roe'][$credit_id] = $rate;
		}
	}
	
	return $data;
}

function add_rule(&$POST){
	$error = array();
	$data = $this->valid_rule_data($POST);
	
	return $this->model->add_rule($data);
}

function update_rule($id, &$POST){
	$error = array();
	$data = $this->valid_rule_data($POST);
	
	return $this->model->update_rule($id, $data);
}

function valid_rule_data(&$POST){
	$data = array();
	$data['credit_id'] = isset($POST['credit_id']) ? intval($POST['credit_id']) : 0;
	$data['role_id'] = isset($POST['role_id']) ? intval($POST['role_id']) : 0;
	$data['system'] = isset($POST['system']) && get_system($POST['system']) ? $POST['system'] : 'core';
	$data['module'] = isset($POST['module']) && get_module($POST['system'], $POST['module']) ? $POST['module'] : '';
	$data['action'] = isset($POST['action']) ? $POST['action'] : '';
	$data['postfix'] = isset($POST['postfix']) ? preg_replace("/[^0-9a-zA-z_]/", '', $POST['postfix']) : '';
	$credit = $this->model->view($data['credit_id']);
	$data['credit'] = isset($POST['credit']) ? 
		(empty($credit['float_bit']) ? intval($POST['credit']) : floatval($POST['credit'])) :
		0;
	$data['times'] = isset($POST['times']) ? intval($POST['times']) : 0;
	$data['interval'] = isset($POST['interval']) ? intval($POST['interval']) : 0;
	
	return $data;
}

}