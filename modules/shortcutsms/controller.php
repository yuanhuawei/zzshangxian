<?php
defined('PHP168_PATH') or die();

class P8_ShortcutSms_Controller extends P8_Controller{

function __construct(&$obj){
	parent::__construct($obj);
}

function P8_ShortcutSms_Controller(&$obj){
	$this->__construct($obj);
}

function check_share(&$data, $action){
	global $UID, $USERNAME, $IS_FOUNDER;
	
	if($data['uid'] == $UID) return true;
	//管理员,创始人必须的
	if($this->check_admin_action('client')) return true;
	
	//
	$data['share_read'];
	$data['share_write'];
}

function add(&$POST){
	$data = $this->valid_data($POST);
	
	return $this->model->add($data);
}

function update($id, &$POST){
	$data = $this->valid_data($POST);
	return $this->model->update($id, $data);
}

function valid_data(&$POST){
	$data = array();
	
	//$data['name'] = isset($POST['name']) ? html_entities($POST['name']) : '';

	$data['content'] = isset($POST['content']) ? p8_html_filter($POST['content']) : '';

	return $data;
}

}