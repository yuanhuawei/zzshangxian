<?php
defined('PHP168_PATH') or die();

/**
* 发送
**/

$this_controller->check_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	$type = isset($_GET['type']) && $_GET['type'] == 'out' ? 'out' : 'in';
	
	
	if($id){
		//以收件箱的消息为发送内容
		$select = select();
		$select->from($this_module->table, 'id, username, title, type, content');
		$select->in('id', $id);
		$select->in($type == 'in' ? 'sendee_uid' : 'sender_uid', $UID);
		
		$data = $core->select($select, array('single' => true));
		$data['title'] = $data['type'] == 'in' ? p8lang($P8LANG['message_reply_title_template'], $data['title']) : $data['title'];
		$data['content'] = $data['type'] == 'in' ? p8lang($P8LANG['message_reply_content_template'], $data['content']) : $data['content'];
	}else{
		//从URL来的参数
		$data = array();
		$data['username'] = isset($_GET['username']) ? $_GET['username'] : '';
		$data['title'] = isset($_GET['title']) ? html_entities($_GET['title']) : '';
		$data['content'] = isset($_GET['content']) ? $_GET['content'] : '';
	}
	if(P8_AJAX_REQUEST){
		$json = p8_json(array('id'=>$id,'type'=>$type,'data'=>$data));
		exit($json);
	}
	include template($this_module, 'send');
	
}else if(REQUEST_METHOD == 'POST'){
	//如果魔法引号开启strip掉
	$_POST = p8_stripslashes2($_POST);
	if(P8_AJAX_REQUEST){
		$_POST = from_utf8($_POST);
	}
	$sendee = isset($_POST['sendee']) ? $_POST['sendee'] : '';

	//以用户名发送
	$_POST['username'] = array_map('trim', explode(',', $sendee));
	
	$this_controller->send($_POST) or message('fail');
	if(P8_AJAX_REQUEST){
		exit(p8_json('done'));
	}
	message('done',$this_url);
}