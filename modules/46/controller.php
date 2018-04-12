<?php
defined('PHP168_PATH') or die();

class P8_46_Controller extends P8_Controller{

function __construct(&$obj){
	parent::__construct($obj);
}

function P8_46_Controller(&$obj){
	$this->__construct($obj);
}

/**
* 添加广告
**/
function add(&$POST){
	$data = $this->valid_data($POST);
	if($data === null) return false;
	
	return $this->model->add($data);
}

/**
* 修改广告
**/
function update($id, $POST){
	$data = $this->valid_data($POST);
	if($data === null) return false;
	
	return $this->model->update($id, $data);
}

/**
* 投放广告
**/
function add_buy(&$POST){
	
	$data = $this->valid_buy($POST);
	if($data === null) return false;
	
	$ad = $this->model->get($data['aid']);
	if(!$ad) return false;
	
	global $UID, $USERNAME;
	
	$data['uid'] = $UID;
	$data['username'] = $USERNAME;
	
	return $this->model->add_buy($data);
}

/**
* 修改投放
**/
function update_buy(&$POST){
	
	$data = $this->valid_buy($POST);
	if($data === null) return false;
	
	$ad = $this->model->get($data['aid']);
	if(!$ad) return false;
	
	$buy = $this->model->get_buy($data['id']);
	if(!$buy) return false;
	
	return $this->model->update_buy($data);
}

/**
* 验证添加广告的数据
**/
function valid_data(&$POST){
	$data = array();
	
	$data['type'] = isset($POST['type']) && isset($this->model->types[$POST['type']]) ? $POST['type'] : '';
	if(!$data['type']) return null;
	
	$data['expense_type'] = isset($POST['expense_type']) && isset($this->model->expense_types[$POST['expense_type']]) ? $POST['expense_type'] : '';
	if(!$data['expense_type']) return null;
	
	$data['name'] = isset($POST['name']) ? html_entities($POST['name']) : '';
	if(!strlen($data['name'])) return null;
	
	$data['link_type'] = empty($POST['link_type']) ? 0 : 1;
	$data['verify'] = empty($POST['verify']) ? 0 : 1;
	
	$data['show_count'] = isset($POST['show_count']) ? intval($POST['show_count']) : 1;
	$data['show_count'] = max(1, $data['show_count']);
	
	$data['max_day'] = isset($POST['max_day']) ? intval($POST['max_day']) : 1;
	$data['max_day'] = max(1, $data['max_day']);
	
	$data['width'] = isset($POST['width']) ? preg_replace('[^0-9%px]', '', $POST['width']) : '';
	$data['height'] = isset($POST['height']) ? preg_replace('[^0-9%px]', '', $POST['height']) : '';
	$data['template'] = isset($POST['template']) ? html_entities(basename($POST['template'])) : '';
	$data['credit'] = isset($POST['credit']) ? intval($POST['credit']) : 0;
	$data['credit_type'] = isset($POST['credit_type']) ? intval($POST['credit_type']) : 0;
	
	$data['buyable'] = empty($POST['buyable']) ? 0 : 1;
	
	return $data;
}

/**
* 验证投放广告的数据
**/
function valid_buy(&$POST){
	$data = array();
	
	$data['attachment_hash'] = isset($POST['attachment_hash']) ? $POST['attachment_hash'] : '';
	$data['id'] = isset($POST['id']) ? intval($POST['id']) : 0;
	$data['aid'] = isset($POST['aid']) ? intval($POST['aid']) : 0;
	if(!$data['aid']) return null;
	
	$ad = $this->model->get($data['aid']);
	if(empty($ad)) return null;
	
	$POST = p8_stripslashes2($POST);
	
	if(isset($POST['credit'])){
		$data['credit'] = intval($POST['credit']);
		$data['credit'] = max(1, $data['credit']);
	}
	
	isset($POST['postfix']) && $data['postfix'] = preg_replace('/[^a-zA-Z0-9_\-]/', '', $POST['postfix']);
	
	$data['comment'] = isset($POST['comment']) ? html_entities($POST['comment']) : '';
	$data['verified'] = empty($POST['verified']) ? 0 : 1;
	$data['showing'] = empty($POST['showing']) ? 0 : 1;
	
	if(isset($POST['expire'])){
		$data['expire'] = strtotime($POST['expire']);
		($data['expire'] === false || $data['expire'] < P8_TIME) && $data['expire'] = 0;
	}
	
	$data['data'] = isset($POST['data']) ? (array)$POST['data'] : array();
	
	switch($ad['type']){
	
	case 'text':
	case 'image':
	case 'flash':
		$tmp = isset($data['data']['url']) ? $this->valid_url($data['data']['url']) : '';
		$tmp2 = isset($data['data']['media']) ? $this->valid_url($data['data']['media']) : '';
		$data['data'] = html_entities($data['data']);
		
		$data['data']['url'] = $tmp;
		$data['data']['media'] = $tmp2;
	break;
		
	case 'effect':
		$tmp = isset($data['data']['media']) ? $this->valid_url($data['data']['media']) : '';
		$data['data'] = html_entities($data['data']);
		
		$data['data']['media'] = $tmp;
	break;
	
	case 'scroll':
		$tmp = isset($data['data']['left']) ? $this->valid_url($data['data']['left']) : '';
		$tmp2 = isset($data['data']['right']) ? $this->valid_url($data['data']['right']) : '';
		$data['data'] = html_entities($data['data']);
		
		$data['data']['left'] = $tmp;
		$data['data']['right'] = $tmp2;
	break;
	
	case 'diy':
		$data['data']['diy'] = isset($data['data']['diy']) ? preg_replace('#</?(?:body|head|html)[^>]*>#i', '', $data['data']['diy']) : '';
	break;
	
	default:
		$data['data'] = html_entities($data['data']);
	}
	
	return $data;
}

/**
* 防止写些onload="alert(document.cookie)"来玩
**/
function valid_url($data){
	if(is_array($data)){
		foreach($data as $k => $v){
			$data[$k] = $this->valid_url($v);
		}
	}else{
		if(!preg_match('#^(http|https)://.+$#i', $data)){
			return '';
		}
		
		$data = str_replace(array('\'', '"', '<', '>', '&#'), '', $data);
	}
	
	return $data;
}

}