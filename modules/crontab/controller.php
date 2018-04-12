<?php
defined('PHP168_PATH') or die();

class P8_Crontab_Controller extends P8_Controller{

function P8_Crontab_Controller(&$obj){
	parent::__construct($obj);
	
}

/**
* 规范时间
**/
function valid_data(&$POST){
	$data = array();
	
	$data['name'] = isset($POST['name']) ? html_entities($POST['name'])	: '';
	$data['script']	= isset($POST['script']) ? basename($POST['script']) : '';
	$data['day'] = isset($POST['day']) ? intval($POST['day']) : 0;
	$data['week'] = isset($POST['week']) ? intval($POST['week']) : 0;
	$data['month'] = isset($POST['month']) ? intval($POST['month']) : 0;
	$data['hour'] = isset($POST['hour']) ? intval($POST['hour']) : 0;
	$data['minute'] = isset($POST['minute']) ? intval($POST['minute']) : 0;
	$data['status'] = empty($POST['status']) ? 0 : 1;
	
	$data['week']	= min(7, $data['week']);	$week	= max(0, $data['week']);
	$data['month']	= min(31, $data['month']);	$month	= max(0, $data['month']);
	$data['hour']	= max(0, $data['hour']);
	$data['minute']	= max(0, $data['minute']);
	
	if($data['day']){
		//按天执行
		$data['hour'] = min(23, $data['hour']);	$data['minute'] = min(59, $data['minute']);
	}else if($data['week']){
		//按星期几执行
		$data['hour'] = min(23, $data['hour']);	$data['minute'] = min(59, $data['minute']);
	}else if($data['month']){
		//按每个月几号执行
		$data['hour'] = min(23, $data['hour']);	$data['minute'] = min(59, $data['minute']);
	}else if($data['hour']){
		//按每几小时执行
		$data['minute'] = min(59, $data['minute']);
	}else if($data['minute']){
		//按每几分钟执行
	}
	
	return $data;
}


function add(&$POST){
	$data = $this->valid_data($POST);
	
	return $this->model->add($data);
}

function update($id, &$POST){
	$data = $this->valid_data($POST);
	
	return $this->model->update($id, $data);
}

}