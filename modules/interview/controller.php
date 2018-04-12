<?php
defined('PHP168_PATH') or die();

class P8_Interview_Controller extends P8_Controller{

	function P8_Interview_Controller(&$obj){
		parent::__construct($obj);

	}

	function add_subject($data){

		$tmpdata = $this->valid_data_subject($data);

		if(empty($tmpdata['title']) || empty($tmpdata['summary'])|| empty($tmpdata['gname'])|| empty($tmpdata['cname']) ||empty($tmpdata['begintime']) || empty($tmpdata['endtime']))
		message('相关数据不能为空！');
		
		return $this->model->add_subject($tmpdata);
	}

	function add_picture($data){

		$tmpdata = $this->valid_data_picture($data);
		if(empty($tmpdata['sid']) || empty($tmpdata['url']) || empty($tmpdata['url']))
		return false;
		
		return $this->model->add_picture($tmpdata);
	}

	function add_content($data){

		$tmpdata = $this->valid_data_content($data);

		if(empty($tmpdata['sid']) || empty($tmpdata['content']))
		return 0;
		
		$id = $this->model->add_content($tmpdata);
		$tmpdata['id'] = $id;
		if($id)
		return $tmpdata;

		return 0;
	}

	function add_ask($data){
		$tmpdata = $this->valid_data_ask($data);
		
		if(empty($tmpdata['sid']) || empty($tmpdata['content']))
		return false;
		
		return $this->model->add_ask($tmpdata);
	}

	function update_subject($data){
		$tmpdata = $this->valid_data_subject($data);

		if(empty($tmpdata['id']) || empty($tmpdata['title']) || empty($tmpdata['summary'])|| empty($tmpdata['gname'])|| empty($tmpdata['cname']) ||empty($tmpdata['begintime']) || empty($tmpdata['endtime']))
		message('相关数据不能为空！');
		
		return $this->model->update_subject($tmpdata);
	}

	function valid_data_subject($data){

		$tmpdata = array();

		$tmpdata['id'] = isset($data['id'])  ? intval($data['id']) : 0;
		$tmpdata['title'] = isset($data['title']) ? html_entities(trim($data['title'])) : '';
		$tmpdata['summary'] = isset($data['summary']) ? html_entities(trim($data['summary'])) : '';
		$tmpdata['status'] = isset($data['status']) ? intval($data['status']) : 0;
		$tmpdata['picture'] = isset($data['picture']) ? attachment_url(trim($data['picture']),true) : '';
		$tmpdata['video'] = isset($data['video']) ? attachment_url($data['video'],true) : '';
		$tmpdata['type'] = isset($data['type']) ? intval($data['type']) : 0;
		$tmpdata['gpicture'] = isset($data['gpicture']) ? attachment_url(trim($data['gpicture']),true) : '';
		$tmpdata['gname'] = isset($data['gname']) ? trim($data['gname']) : '';
		$tmpdata['gintroduction'] = isset($data['gintroduction']) ? p8_html_filter(trim($data['gintroduction'])) : '';
		$tmpdata['cpicture'] = isset($data['cpicture']) ? attachment_url(trim($data['cpicture']),true) : '';
		$tmpdata['cname'] = isset($data['cname']) ? trim($data['cname']) : '';
		$tmpdata['cintroduction'] = isset($data['cintroduction']) ? p8_html_filter(trim($data['cintroduction'])) : '';
		$tmpdata['begintime'] = isset($data['begintime']) ? (preg_match("/\d{4}-\d{2}-\d{2}/",$data['begintime']) ? strtotime($data['begintime']) : 0) : 0;
		$tmpdata['endtime'] = isset($data['endtime']) ? (preg_match("/\d{4}-\d{2}-\d{2}/",$data['endtime']) ? strtotime($data['endtime']) : 0) : 0;
		$tmpdata['posttime'] = P8_TIME;

		return $tmpdata;
	}

	function valid_data_picture($data){
		global $core;
		
		$tmpdata = array();

		$tmpdata['id'] = isset($data['id'])  ? intval($data['id']) : 0;
		$tmpdata['sid'] = isset($data['sid'])  ? intval($data['sid']) : 0;
		$tmpdata['url'] = isset($data['url']) ? trim($data['url']) : '';
		$tmpdata['summary'] = isset($data['summary']) ? convert_encode("utf-8",$core->CONFIG['page_charset'],preg_replace("/\n/","<br/>",trim($data['summary']))) : '';
		$tmpdata['posttime'] = P8_TIME;
		
		return $tmpdata;
	}

	function valid_data_content($data){
		global $core;
		$tmpdata = array();

		$tmpdata['id'] = isset($data['id'])  ? intval($data['id']) : 0;
		$tmpdata['sid'] = isset($data['sid']) ? intval($data['sid']) : 0;
		$tmpdata['sender'] = isset($data['sender']) ? intval($data['sender']) : 0;
		$tmpdata['content'] = isset($data['content']) ? convert_encode("utf-8",$core->CONFIG['page_charset'],preg_replace("/\n/","<br/>",trim($data['content']))) : '';
		$tmpdata['posttime'] = P8_TIME;

		return $tmpdata;
	}

	function valid_data_ask($data){
		global $core;

		$tmpdata = array();

		$tmpdata['id'] = isset($data['id'])  ? intval($data['id']) : 0;
		$tmpdata['sid'] = isset($data['sid']) ? intval($data['sid']) : 0;
		$tmpdata['username'] = isset($data['username']) ? convert_encode("utf-8",$core->CONFIG['page_charset'],preg_replace("/\n/","<br/>",trim($data['username']))) : '';
		$tmpdata['content'] = isset($data['content']) ? convert_encode("utf-8",$core->CONFIG['page_charset'],preg_replace("/\n/","<br/>",trim($data['content']))) : '';
		$tmpdata['status'] = isset($data['status']) ? 1 : 0;
		$tmpdata['ip'] = P8_IP;
		$tmpdata['posttime'] = P8_TIME;

		return $tmpdata;
	}
}