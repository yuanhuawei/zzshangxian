<?php
defined('PHP168_PATH') or die();

class P8_CMS_Assist_category_Controller extends P8_Controller{

	function P8_CMS_Assist_category_Controller(&$obj){
		parent::__construct($obj);
	}
	
	function add_sort($POST){
		
		$data = $this->valid_sort_data($POST);
		return $this->model->add_sort($data);
	}
	
	function update_sort($POST){
		$id = intval($POST['id']);
		$id or message('fail');
		$data = $this->valid_sort_data($POST);
		if($id==$data['parent'])message('fail');
		return $this->model->update_sort($data,$id);
	}
	
	function valid_sort_data($POST){
		
		$data = array();
		//Ãû³Æ
		$data['name'] = isset($POST['name']) ? html_entities($POST['name']) : '';
		if(!strlen($data['name'])) return null;
		$data['type'] = isset($POST['type']) ? intval($POST['type']) : 2;
		$data['parent'] = isset($POST['parent']) ? $POST['parent'] : 0;
		return $data;
	}

}