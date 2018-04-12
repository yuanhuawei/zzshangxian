<?php
defined('PHP168_PATH') or die();

class P8_Spider_Controller extends P8_Controller{

function __construct(&$obj){
	parent::__construct($obj);
}

function P8_Spider_Controller(&$obj){
	$this->__construct($obj);
}

function add_rule(&$POST){
	
	$data = $this->valid_data($POST);
	$data['timestamp'] = P8_TIME;
	
	return $this->model->add_rule($data);
}

function update_rule($id, &$POST){
	$data = $this->valid_data($POST);
	
	return $this->model->update_rule($id, $data);
}

function add_category(&$POST){
	$data = $this->valid_category_data($POST);
	
	return $this->model->add_category($data);
}

function update_category($id, &$POST){
	$data = $this->valid_category_data($POST);
	
	return $this->model->update_category($id, $data);
}

function valid_data(&$POST){
	$data = array();
	
	$data['name'] = isset($POST['name']) ? html_entities($POST['name']) : '';
	$data['cid'] = isset($POST['cid']) ? intval($POST['cid']) : '';
	$data['data'] = isset($POST['data']) ? (array)$POST['data'] : array();
	
	$data['data']['timeout'] = isset($POST['data']['timeout']) ? intval($POST['data']['timeout']) : 0;
	$data['data']['timeout'] = max($data['data']['timeout'], 0);
	$data['data']['capture_frame'] = empty($data['data']['capture_frame']) ? 0 : 1;
	$data['data']['reverse'] = empty($data['data']['reverse']) ? 0 : 1;
	$data['data']['start'] = isset($data['data']['start']) ? trim($POST['data']['start']) : 0;
	$data['data']['end'] = isset($data['data']['end']) ? trim($POST['data']['end']) : '';
	$data['data']['list_page_start'] = isset($data['data']['list_page_start']) ? trim($POST['data']['list_page_start']) : '';
	$data['data']['list_page_end'] = isset($data['data']['list_page_end']) ? trim($POST['data']['list_page_end']) : '';
	$data['data']['content_page_start'] = isset($data['data']['content_page_start']) ? trim($POST['data']['content_page_start']) : '';
	$data['data']['content_page_end'] = isset($data['data']['content_page_end']) ? trim($POST['data']['content_page_end']) : '';
	
	$diy_rule_reg = isset($POST['data']['diy_rule']['reg']) ? (array)$POST['data']['diy_rule']['reg'] : array();
	
	$i = 0;
	$diy_rule = array();
	foreach($diy_rule_reg as $k => $v){
		$v = trim($v);
		if(!$v) continue;
		
		$diy_rule[$i]['reg'] = $v;
		$diy_rule[$i]['start'] = isset($data['data']['diy_rule']['start'][$k]) ? trim($data['data']['diy_rule']['start'][$k]) : '';
		$diy_rule[$i]['end'] = isset($data['data']['diy_rule']['end'][$k]) ? trim($data['data']['diy_rule']['end'][$k]) : '';
		$diy_rule[$i]['replace'] = isset($data['data']['diy_rule']['replace'][$k]) ? trim($data['data']['diy_rule']['replace'][$k]) : '';
		
		$i++;
	}
	$data['data']['diy_rule'] = $diy_rule;
	
	return $data;
}

function valid_category_data(&$POST){
	$data = array();
	
	$data['name'] = isset($POST['name']) ? html_entities($POST['name']) : '';
	$data['display_order'] = isset($POST['display_order']) ? intval($POST['display_order']) : 0;
	
	return $data;
}

}