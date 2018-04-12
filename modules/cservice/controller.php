<?php
defined('PHP168_PATH') or die();

class P8_CService_Controller extends P8_Controller{

function P8_CService_Controller(&$obj){
	parent::__construct($obj);
	
}

function add(&$POST){
	global $UID,$USERNAME;
	$data=$this->valid($POST);
	$data['num']=date('ymd',P8_TIME).mt_rand(100,999);
	$this->model->add($data);
	if($POST['sendmsg'] && $POST['telephone'])$this->sendmsg($POST['telephone']);

}

function update($POST){
	$data=$this->valid($POST);
	$this->model->updatereply($data);
	if($POST['sendmsg'] && $POST['telephone'])$this->sendmsg($POST['telephone']);

}
function updateask($POST){
	$data=$this->valid($POST);
	$id = intval($POST['id']);
	unset($data['uid'],$data['username']);
	$this->model->updateask($data,$id);
	if($POST['sendmsg'] && $POST['telephone'])$this->sendmsg($POST['telephone']);

}
function reply($POST){
	$data=$this->valid($POST);
	if(!empty($data['replay_id'])){
		$this->model->updatereply($data);
	}else{
		$this->model->reply($data);
	}
}
function valid($POST){
	global $UID,$USERNAME;
	isset($POST['title']) && $data['title'] = html_entities($POST['title']);
	!empty($POST['site']) && $data['site']=html_entities($POST['site']);
	!empty($POST['ip']) && $data['ip']=html_entities($POST['ip']);
	!empty($POST['content']) && $data['content']=html_entities($POST['content']);
	!empty($POST['frame']) && $data['frame'] =attachment_url(html_entities($POST['frame']), true);
	!empty($POST['mobilephone']) && $data['mobilephone']=html_entities($POST['mobilephone']);
	!empty($POST['ip']) && $data['ip']=$POST['ip'];
	!empty($POST['priority']) && $data['priority']=$POST['priority'];
	!empty($POST['category']) && $data['category']=$POST['category'];
	!empty($POST['askid']) && $data['askid']=$POST['askid'];
	!empty($POST['repid']) && $data['repid']=$POST['repid'];
	!empty($POST['replay_id']) && $data['replay_id']=$POST['replay_id'];
	//关联附件哈希
	$data['attachment_hash'] = isset($POST['attachment_hash']) ? $POST['attachment_hash'] : '';
	$data['uid']=$UID;
	$data['username']=$USERNAME;
	return $data;
}
function format_data($data){

	foreach ($data as $key => $val){
		$_data[$val['id']]=$val;
	}

	unset($data);
	foreach($_data as $k => $v){
		$_data[$k]['content']=html_decode_entities($v['content']);
		$_data[$k]['frame']=attachment_url($v['frame']);
		if($v['repid']){
			$_data[$v['repid']]['replay']=$v;
			$_data[$v['repid']]['replay_id']=$v['id'];
			unset($_data[$k]);
		}
		
	}
	return $_data;
}
function sendmsg($tele){
	
}


}