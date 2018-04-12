<?php
defined('PHP168_PATH') or die();

class P8_Special_Controller extends P8_Controller{

function P8_Special_Controller(&$obj){
	parent::__construct($obj);
	
}

function add(&$POST){
	$data = $this->valid_data($POST);
	$id = $this->model->add($data);
	$status = $this->model->category->update_count($data['cid'], 1);
	return $id;
}

function update($id, &$POST){
	$data = $this->valid_data($POST);
	return $this->model->update($id, $data);
}

function valid_data(&$POST){
	$data = array();
	$data['title'] = isset($POST['title']) ? html_entities($POST['title']) : '';
	$data['banner'] = isset($POST['banner']) ? attachment_url(html_entities($POST['banner']),true) : '';
	$data['frame'] = isset($POST['frame']) ? attachment_url(html_entities($POST['frame']),true) : '';
	$data['cid'] = isset($POST['cid']) ? intval($POST['cid']) : '';
	$data['html_view_url_rule'] = isset($POST['html_view_url_rule']) ? html_entities($POST['html_view_url_rule']) : '';
	
	$acl = $this->core->load_acl('core', '', $this->core->ROLE);
	$data['description'] = isset($POST['description']) ? p8_html_filter($POST['description'], $acl['allow_tags'], $acl['disallow_tags']) : '';
	$data['seo_keywords'] = isset($POST['seo_keywords']) ? filter_word(html_entities($POST['seo_keywords'])):'';
	$data['ifcomment'] = isset($POST['ifcomment']) ? $POST['ifcomment'] : 0;
	
	$template['tpl_head'] = isset($POST['tpl_head']) ? html_entities($POST['tpl_head']) : '';
	$template['tpl_main'] = isset($POST['tpl_main']) ? html_entities($POST['tpl_main']) : '';
	$template['tpl_foot'] = isset($POST['tpl_foot']) ? html_entities($POST['tpl_foot']) : '';
	$data['template'] = serialize($template);
	
	$data['navigation'] = isset($POST['navigation']) ? $this->make_navigation($POST['navigation']) : '';
	return $data;
	
}

function make_navigation($data){
	foreach($data as $k => $v){
		if(empty($v['name']))continue;
		$v['name']=html_entities($v['name']);
		$v['url']=html_entities($v['url']);
		$v['order']=$order[$k]=intval($v['order']);
		$_data[$k]=$v;
	}
	if(!empty($order))array_multisort($order,SORT_DESC,$_data);
	return serialize($_data);
}

function gettemplate($template=''){
	$template=mb_unserialize($template);
	$tpl['main']='main/'.($template['tpl_main']?$template['tpl_main']:'content');
	$tpl['header']='head/'.($template['tpl_head']?$template['tpl_head']:'header');
	$tpl['footer']='foot/'.($template['tpl_foot']?$template['tpl_foot']:'footer');
	return $tpl;
}
function get_templatestyle(){
	return (!empty($this->model->CONFIG['template']) && is_dir(TEMPLATE_PATH.$this->model->CONFIG['template'].'/core/'.$this->model->name))?$this->model->CONFIG['template']:'default';
}
}