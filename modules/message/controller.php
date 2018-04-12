<?php
defined('PHP168_PATH') or die();

class P8_Message_Controller extends P8_Controller{

function __construct(&$obj){
	parent::__construct($obj);
}

function P8_Message_Controller(&$obj){
	$this->__construct($obj);
}

function send(&$POST){
	$data = $this->valid_data($POST);
	if($data === null) return false;
	
	return $this->model->send($data);
}

function valid_data(&$POST){
	
	$data = array();
	
	if(isset($POST['uid'])){
		$data['uid'] = filter_int($POST['uid']);
		
		if(empty($data['uid'])) return null;
		
	}else if(isset($POST['username'])){
		$tmp = (array) $POST['username'];
		$data['username'] = array();
		foreach($tmp as $v){
			$v = trim($v);
			if(!strlen($v)) continue;
			
			$data['username'][] = html_entities($v);
		}
		
		if(empty($data['username'])) return null;
	}
	
	$data['title'] = isset($POST['title']) ? html_entities($POST['title']) : '';
	$acl = $this->core->load_acl('core', '', $this->core->ROLE);
	$data['content'] = isset($POST['content']) ? p8_html_filter(html_entities($POST['content']), $acl['allow_tags'], $acl['disallow_tags']) : '';
	$data['outbox'] = empty($POST['outbox']) ? 0 : 1;
	$data['draft'] = empty($POST['draft']) ? 0 : 1;
	$data['notice'] = isset($_POST['notice']) ? $_POST['notice'] : '';
	$data['email'] = isset($_POST['email']) ? $_POST['email'] : 'false';
	$data['cell_phone'] = isset($_POST['cell_phone']) ? $_POST['cell_phone'] : 'false';
	
	return $data;
}

}