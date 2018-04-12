<?php
defined('PHP168_PATH') or die();

class P8_Guestbook_Controller extends P8_Controller{

function P8_Guestbook_Controller(&$obj){
	parent::__construct($obj);
	
}
/*增加分类*/
function add_category(&$POST){

	$data['name']=!empty($POST['name'])? html_entities($POST['name']) : '';
	if(!$data['name'])return false;
	$data['ifclose'] = !empty($POST['ifclose'])? intval($POST['ifclose']):0;
	$data['ifcaptcha'] = !empty($POST['ifcaptcha'])? intval($POST['ifcaptcha']):0;
	return $this->model->add_category($data);
}
/*修改分类*/
function edit_category(&$POST){

	$data['name']=!empty($POST['name'])? html_entities($POST['name']) : '';
	$data['ifclose'] = !empty($POST['ifclose'])? intval($POST['ifclose']):0;
	$data['ifcaptcha'] = !empty($POST['ifcaptcha'])? intval($POST['ifcaptcha']):0;
	$id = !empty($POST['id'])? intval($POST['id']):'';
	if(!$data['name'] || !$id)return false;
	return $this->model->edit_category($id,$data);
}

/*发表*/
function add(&$POST){
	global $UID;
	$data=$this->verify_data($POST);
	$data['verified']=intval($POST['verify']);
	$data['posttime']=P8_TIME;
	$data['ip']=P8_IP;
	$data['uid']=$UID;
	$data['username']=($data['username'])? $data['username'] : '';
	return $this->model->add($data);
}


function verify_data($POST){
	global $USERNAME,$P8LANG;
	$captcha = isset($POST['captcha'])?p8_html_filter($POST['captcha']):'';
	$data['cid'] = !empty($POST['cid'])? intval($POST['cid']):0;
	if(!empty($this->model->CONFIG['captcha']) && !captcha($captcha)){
		message('captcha_incorrect', HTTP_REFERER, 10);
	}
	$data['title']=!empty($POST['title'])? html_entities($POST['title']) : '';
	$data['content']=!empty($POST['content'])? html_entities($POST['content']) : '';
	$data['username']=!empty($POST['niname'])? $USERNAME : $P8LANG['guestbook']['noname'];
	$data['email']=!empty($POST['email'])? html_entities($POST['email']) : '';
	$data['telephone']=!empty($POST['telephone'])? html_entities($POST['telephone']) : '';
	$data['ifhide'] = !empty($POST['ifhide'])? intval($POST['ifhide']):0;
	
	return $data;
}

function check_one($id){
	global $UID;
	$data = $this->model->get($id);
	return $UID==$data['uid'];

}

function update($POST){
	$id=intval($POST['id']);
	if(!$id) return;
	$data=$this->verify_data($POST);
	
	return $this->model->update($data,$id);

}

function format_data($data){
	foreach($data as $key=>$val){
		$data[$key]['content']=str_replace("\r\n","<br>",$val['content']);
		$data[$key]['sip'] = preg_replace("/(\d+\.\d+\.)\d+(\.\d+)/","\\1*\\2",$data[$key]['ip']);
	
	}
return $data;
}

}