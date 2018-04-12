<?php
defined('PHP168_PATH') or die();

class P8_Friendlink_Controller extends P8_Controller{

function P8_Friendlink_Controller(&$obj){
	parent::__construct($obj);
	
}


function add_sort($POST){
	
	$datas = array();
	$datas = $this->valid_data($POST);
	if(empty($datas['sort']['name'])) return false;
	return $this->model->add_sort($datas['sort']);
}

function add_link($POST){
	
	$datas = array();
	$datas = $this->valid_data($POST);
	if(empty($datas['link']['name']) ||empty($datas['link']['fid']) ||empty($datas['link']['url'])) return false;
	return $this->model->add_link($datas['link']);
}

function update_link($POST){
	
	$datas = array();
	$datas = $this->valid_data($POST);
	if(empty($datas['link']['id']) ||empty($datas['link']['name']) ||empty($datas['link']['fid']) ||empty($datas['link']['url'])) return false;
	return $this->model->update_link($datas['link']);
}
function update_list($lists){
	is_array($lists) or message('err');
	foreach($lists as $key=>$list){
		$this->model->update_list(array('id'=>$key,'list'=>$list));
	}
}
function update_sort($POST){
	
	$datas = array();
	$datas = $this->valid_data($POST);
	if(empty($datas['sort']['fid']) ||empty($datas['sort']['name'])) return false;
	return $this->model->update_sort($datas['sort']);
}

function valid_data($POST){
	
	$datas = array();
	
	//分类信息
	$datas['sort'] = isset($POST['sort']) ? (array)$POST['sort'] : array();
	$datas['sort']['fid'] = isset($datas['sort']['fid']) ? intval($datas['sort']['fid']) : 0 ;
	$datas['sort']['name'] = isset($datas['sort']['name']) ? trim($datas['sort']['name']) : '' ;
	$datas['sort']['list'] = isset($datas['sort']['name']) ? intval($datas['sort']['list']) : 0 ;
	
	//链接信息
	$datas['link'] = isset($POST['link']) ? (array)$POST['link'] : array();
	$datas['link']['id'] = isset($datas['link']['id']) ? intval($datas['link']['id']) : 0 ;
	$datas['link']['name'] = isset($datas['link']['name']) ? trim($datas['link']['name']) : '' ;
	$datas['link']['fid'] = isset($datas['link']['fid']) ? intval($datas['link']['fid']) : 0 ;
	$datas['link']['url'] = isset($datas['link']['url']) ? trim($datas['link']['url']) : '' ;
	$datas['link']['logo'] = isset($datas['link']['logo']) ? attachment_url($datas['link']['logo'], true) : '' ;
	$datas['link']['descrip'] = isset($datas['link']['descrip']) ? $datas['link']['descrip'] : '' ;
	$datas['link']['ifhide'] = isset($datas['link']['ifhide']) ? intval($datas['link']['ifhide']) : 0 ;
	$datas['link']['yz'] = isset($datas['link']['yz']) ? intval($datas['link']['yz']) : 0 ;
	$datas['link']['iswordlink'] = isset($datas['link']['iswordlink']) ? intval($datas['link']['iswordlink']) : 0 ;
	$datas['link']['endtime'] = isset($datas['link']['endtime']) ? trim($datas['link']['endtime']) : 0 ;
	$datas['link']['endtime'] = empty($datas['link']['endtime']) ? 0 : strtotime($datas['link']['endtime']);
	return $datas;
}
}