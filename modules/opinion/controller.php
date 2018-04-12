<?php
defined('PHP168_PATH') or die();

class P8_Opinion_Controller extends P8_Controller{

function __construct(&$obj){
	parent::__construct($obj);
}

function P8_Opinion_Controller(&$obj){
	$this->__construct($obj);
}

function add(&$POST){
	global $UID,$USERNAME;
	$data = array();
	$data['email'] = html_entities(from_utf8($POST['commentEmail']));
	//$data['title'] = html_entities(from_utf8($POST['commentTitle']));
	$data['name'] = html_entities(from_utf8($POST['commentUsername']));
	$data['mobile'] = html_entities(from_utf8($POST['mobile']));
	$data['content'] = html_entities(from_utf8($POST['commentContnet']));
	$data['iid'] = intval($POST['iid']);
	if(!$data['content'] || !$data['iid'])return false;
	$data['timestamp'] = P8_TIME;
	$data['uid'] = $UID;
	$data['ip'] = P8_IP;
	$data['status'] = !empty($this->model->CONFIG['undisplay'])?0:1;
	return $this->model->add($data);
}

/**
* 提交表单
**/
function add_item(&$POST){

	global  $UID, $USERNAME;
	
	//验证数据
	$data = $this->valid_item($POST);

	if($data === null) return false;
	
	$data['timestamp'] = P8_TIME;
	
	$id = $this->model->add_item($data);
	
	return $id;
}

function update_item(&$POST){
	//验证数据
	$data = $this->valid_item($POST);
	$id = intval($POST['id']);
	if($data === null) return false;
	return  $this->model->update_item($id, $data);
}

function delete_item($post){
	$id = intval($post['id']);
	return  $this->model->delete_item($id);
}

/**
* 验证数据
* @param array $POST
**/
function valid_item(&$POST){
	$data = array();
	$data['title'] = isset($POST['title']) ? html_entities($POST['title']) : '';
	$data['endtime'] = isset($POST['endtime']) ? strtotime(trim($POST['endtime'])) : '';
	$data['content'] = !empty($POST['content']) ? attachment_url( filter_word($POST['content']), true):'';
	$data['status'] = empty($POST['status']) ? 0 : 1;
	$data['captcha'] = empty($POST['captcha']) ? 0 : 1;
	$data['post_template'] = empty($POST['post_template']) ? '' : $POST['post_template'];
	$data['list_template'] = empty($POST['list_template']) ? '' : $POST['list_template'];
	
	return $data;
}


/**
* 添加一个字段
* @param array $POST 数据
**/
function add_data(&$POST){
	$data = $this->valid_data($POST);
	
	$data['uid'] = $UID;
	$data['main']['ip'] = P8_IP;
	$data['timestamp'] = P8_TIME;
	$data['iid'] = intval($POST['iid']);
	
	$id = $this->model->add_data($data);
	$this->model->update_count($data['iid'],1);
	return $id;
}
/**
* 修改一个字段
* @param int $id ID
* @param array $POST 数据
**/
function update_data($id, &$POST){
	$data = $this->valid_data($POST);

	return $this->model->update_field($id, $data);
}

/**
* 验证模型字段数据
* @param array $POST
**/
function valid_data(&$POST){
	
	$data = array();

	$data['name'] = isset($POST['name']) ? html_entities($POST['name']) : '';
	$data['tel'] = isset($POST['tel']) ? html_entities($POST['tel']) : 0;
	$data['mobile'] = isset($POST['mobile']) ? html_entities($POST['mobile']) : '';
	$data['title'] = isset($POST['title']) ? html_entities($POST['title']) : '';
	
	$data['content'] = !empty($POST['content']) ? attachment_url( filter_word($POST['content']), true):'';
	
	return $data;
}


function delete_data($post){
	$id = intval($post['id']);
	return  $this->model->delete_data($id);
}
}