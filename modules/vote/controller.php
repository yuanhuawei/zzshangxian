<?php
defined('PHP168_PATH') or die();

class P8_Vote_Controller extends P8_Controller{

function __construct(&$obj){
	parent::__construct($obj);
}

function P8_Vote_Controller(&$obj){
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

function add_option($POST){
	$data = $this->valid_option($POST);
	
	return $this->model->add_option($POST);
}

function valid_data(&$POST){
	$data = array();
	
	$data['name'] = isset($POST['name']) ? html_entities($POST['name']) : '';
	$data['content'] = isset($POST['content']) ? html_entities($POST['content']) : '';
	$data['template'] = isset($POST['template']) ? html_entities(basename($POST['template'])) : '';
	$data['label_template'] = isset($POST['label_template']) ? html_entities($POST['label_template']) : '';
	$data['frame'] = isset($POST['frame']) ? attachment_url($POST['frame'], true) : '';
	$data['vote_interval'] = isset($POST['vote_interval']) ? intval($POST['vote_interval']) : 1;
	$data['vote_interval'] = max($data['vote_interval'], 1);
	
	$data['page_size'] = isset($POST['page_size']) ? intval($POST['page_size']) : 0;
	$data['page_size'] = max($data['page_size'], 0);
	
	$data['multi'] = isset($POST['multi']) ? intval($POST['multi']) : 1;
	$data['multi'] = max($data['multi'], 0);
	
	$data['viewable'] = empty($POST['viewable']) ? 0 : 1;
	$data['vote_to_view'] = empty($POST['vote_to_view']) ? 0 : 1;
	$data['view_voter'] = empty($POST['view_voter']) ? 0 : 1;
	$data['enabled'] = empty($POST['enabled']) ? 0 : 1;
	$data['captcha'] = empty($POST['captcha']) ? 0 : 1;
	if(isset($POST['expire'])){
		$data['expire'] = strtotime($POST['expire']);
		($data['expire'] === false) && $data['expire'] = 0;
	}
	
	$data['roles'] = isset($POST['roles']) ? (array)$POST['roles'] : array();
	$data['roles'] = implode('|', $data['roles']);
	
	$options = isset($POST['options']) ? (array)$POST['options'] : array();
	$data['options'] = array();
	foreach($options as $k => $v){
		$data['options'][$k] = $this->valid_option($v);
	}
	
	$data['attachment_hash'] = isset($POST['attachment_hash']) ? $POST['attachment_hash'] : '';
	
	return $data;
}

function valid_option(&$POST){
	$data = array();
	
	$data['vid'] = isset($POST['vid']) ? intval($POST['vid']) : 0;
	$data['name'] = isset($POST['name']) ? html_entities($POST['name']) : '';
	$data['description'] = isset($POST['description']) ? html_entities($POST['description']) : '';
	$data['display_order'] = isset($POST['display_order']) ? intval($POST['display_order']) : '';
	
	return $data;
}

}