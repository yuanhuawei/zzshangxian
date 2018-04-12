<?php
defined('PHP168_PATH') or die();

class P8_CMS_Statistic_Controller extends P8_Controller{

	function P8_CMS_Statistic_Controller(&$obj){
		parent::__construct($obj);
	}
	
	function add_sort($POST){
		
		$data = $this->valid_sort_data($POST);
		return $this->model->add_sort($data);
	}
	
}