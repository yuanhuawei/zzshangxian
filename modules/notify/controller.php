<?php
defined('PHP168_PATH') or die();

class P8_Notify_Controller extends P8_Controller{

function __construct(&$obj){
	parent::__construct($obj);
}

function P8_Notify_Controller(&$obj){
	$this->__construct($obj);
}

function add(&$POST){
	
	global $UID;
	
	$data = $this->valid_data($POST);
	$data['timestamp'] = P8_TIME;
	$data['uid'] = $UID;
	
	return $this->model->add($data);
}

function update($id, &$POST){
	
	$data = $this->valid_data($POST);
	
	return $this->model->update($id, $data);
}

function sign_in(&$POST){
	$data = $this->valid_sign_in($POST);
	
	return $this->model->sign_in($data);
}

function valid_data(&$POST){
	global $USERNAME;
	$data = array();
	
	$data['title'] = isset($POST['title']) ? html_entities($POST['title']) : '';
	$data['username'] = $USERNAME;
	$acl = $this->core->load_acl('core', '', $this->core->ROLE);
	$data['content'] = isset($POST['content']) ? p8_html_filter($POST['content'], $acl['allow_tags'], $acl['disallow_tags']) : '';
	$data['expire'] = isset($POST['expire']) ? strtotime($POST['expire']) : P8_TIME;
	$data['send_pm'] = empty($POST['send_pm']) ? 0 : 1;
	$data['send_mail'] = empty($POST['send_mail']) ? 0 : 1;
	$data['send_sms'] = empty($POST['send_sms']) ? 0 : 1;
	$data['sms_back'] = empty($POST['sms_back']) ? 0 : 1;
	$data['data'] = isset($POST['data']) ? html_entities($POST['data']) : '';
	
	return $data;
}

function valid_sign_in(&$POST){
	$data = array();
	
	$data['id'] = isset($POST['id']) ? intval($POST['id']) : 0;
	$data['uid'] = isset($POST['uid']) ? intval($POST['uid']) : 0;
	$data['hash'] = isset($POST['hash']) ? preg_replace('/[^a-zA-Z0-9]/', '', $POST['hash']) : '';
	$data['status'] = isset($POST['status']) ? intval($POST['status']) : 0;
	$data['comment'] = isset($POST['comment']) ? html_entities($POST['comment']) : '';
	
	return $data;
}

}