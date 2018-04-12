<?php
defined('PHP168_PATH') or die();

class P8_Survey_Controller extends P8_Controller{

function __construct(&$obj){
	parent::__construct($obj);
}

function P8_Survey_Controller(&$obj){
	$this->__construct($obj);
}


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

function valid_item(&$POST){
	$data = array();
	$data['title'] = isset($POST['title']) ? html_entities($POST['title']) : '';
	$data['endtime'] = isset($POST['endtime']) ? strtotime(trim($POST['endtime'])) : '';
	$data['content'] = !empty($POST['content']) ? attachment_url( filter_word($POST['content']), true):'';
	$data['status'] = empty($POST['status']) ? 0 : 1;
	$data['captcha'] = empty($POST['captcha']) ? 0 : 1;
	$data['post_template'] = empty($POST['post_template']) ? '' : $POST['post_template'];
	$data['list_template'] = empty($POST['list_template']) ? '' : $POST['list_template'];
	$data['view_template'] = empty($POST['view_template']) ? '' : $POST['view_template'];
	
	return $data;
}



function add_title(&$POST){
	$data = $this->valid_title($POST);
	$data['iid'] = intval($POST['iid']);
	$id = $this->model->add_title($data);
	return $id;
}

function update_title($id, &$POST){
	$data = $this->valid_title($POST);

	return $this->model->update_title($id, $data);
}

function valid_title(&$POST){
	
	$data = array();

	$data['tittle'] = isset($POST['tittle']) ? html_entities($POST['tittle']) : '';
	$data['display_order'] = isset($POST['display_order']) ? intval($POST['display_order']) : 0;
	$data['not_null'] = isset($POST['not_null']) ? intval($POST['not_null']) : 0;
	$data['other'] = isset($POST['other']) ? intval($POST['other']) : 0;
	$data['type'] = isset($POST['type']) ? html_entities($POST['type']) : '';
	
	$data_key = isset($POST['data_key']) ? (array)$POST['data_key'] : array();
	$data_value = isset($POST['data_value']) ? (array)$POST['data_value'] : array();
	$data['data'] = array();
	foreach($data_key as $k => $v){
		if(empty($data_value[$k])) continue;
		$data['data'][html_entities($v)] = html_entities($data_value[$k]);
	}
	$data['data'] = serialize($data['data']);
	return $data;
}


function delete_title($post){
	$id = intval($post['id']);
	return  $this->model->delete_title($id);
}




function add_data(&$POST){
	global $UID,$USERNAME;
	$addon = $this->valid_data($POST);

	$data['uid'] = $UID;
	$data['name'] = $USERNAME;
	$data['ip'] = P8_IP;
	$data['timestamp'] = P8_TIME;
	$data['iid'] = intval($POST['iid']);
	
	$id = $this->model->add_data($data,$addon);

	$this->model->update_count($data['iid'],1);
	return $id;
}

function update_data($id, &$POST){
	$data = $this->valid_data($POST);

	return $this->model->update_field($id, $data);
}

function valid_data(&$POST){
	
	$data = array();
	
	$iid = $POST['iid'];
	$titles = $this->model->get_titles($iid);
	$pt = $POST['title'];
	$others = $POST['other'];
	foreach($titles as $title){
		
		if($title['type']=='checkbox')
			$answer = implode(',',html_entities($pt[$title['id']]));
		else
			$answer = html_entities($pt[$title['id']]);
		
		$other = $title['other']? html_entities($others[$title['id']]):'';

		$data[$title['id']] = array('data'=>$answer,'other'=>$other );
	}

	return $data;
}


function delete_data($post){
	$id = intval($post['id']);
	return  $this->model->delete_data($id);
}
}