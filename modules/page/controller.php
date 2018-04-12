<?php
defined('PHP168_PATH') or die();

class P8_Page_Controller extends P8_Controller{

function __construct(&$obj){
	parent::__construct($obj);
}

function P8_Page_Controller(&$obj){
	$this->__construct($obj);
}

function add(&$POST){
	$data = $this->verify($POST);
	$data['timestamp'] = P8_TIME;
	
	return $this->model->add($data);
}

function edit(&$POST){
	$data = $this->verify($POST);
	$data['id'] = intval($POST['id']);
	return $this->model->edit($data);
}

function delete($id){
	$this->model->delete($id);
}

function verify(&$POST){
	global $UID;
	$data['name'] = isset($POST['name']) ? $POST['name'] : '';
	$data['title'] = isset($POST['title']) ? $POST['title'] : '';
	$data['keywords'] = isset($POST['keywords'])? filter_word(html_entities($POST['keywords'])) : '';
	$data['descrip'] = isset($POST['descrip']) ? filter_word(html_entities($POST['descrip'])) : '';
	$data['content'] = isset($POST['content']) ? attachment_url(filter_word(p8_html_filter($POST['content'])), true) : '';

	$data['tpl_head'] = isset($POST['tpl_head']) ? html_entities($POST['tpl_head']) : '';
	$data['tpl_main'] = isset($POST['tpl_main']) ? html_entities($POST['tpl_main']) : 'page';
	$data['tpl_foot'] = isset($POST['tpl_foot']) ? html_entities($POST['tpl_foot']) : '';

	$data['tpl_mobile'] = isset($POST['tpl_mobile']) ? html_entities($POST['tpl_mobile']) : 'page';
	
	$data['html_view_url_rule'] = html_entities($POST['html_view_url_rule']);
	$data['type'] = html_entities($POST['type']);
	
	return $data;
}

function gettemplate($type,$main,$head='',$foot='',$mobile=''){
	$tpdir='main/';
	if(!$type){
		$tpdir='alonepage/';
	}
	$tp['main']=$tpdir.$main;
	$head && $tp['header']='header/'.$head;
	$foot && $tp['foot']='foot/'.$foot;
	
	if(ISMOBILE)
	{
		$tpdir='mobile/';
		$tp['main']=$tpdir.($mobile?$mobile:'page');
	}
	
	return $tp;
}

function get_templatestyle(){
	return (!empty($this->model->CONFIG['template']) && is_dir(TEMPLATE_PATH.$this->model->CONFIG['template'].'/core/'.$this->model->name))?$this->model->CONFIG['template']:'default';
}

function addcontent(&$POST){
	$data['id'] = $POST['id'];

	$acl = $this->core->load_acl('core', '', $this->core->ROLE);
	$data['content'] =  isset($POST['content']) ?
		attachment_url(p8_html_filter($POST['content'], $acl['allow_tags'], $acl['disallow_tags']),true) :
		'';
		$this->model->addcontent($data);
}
}