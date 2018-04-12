<?php
/**
*发布快速信息
**/
defined('PHP168_PATH') or die();

$this_controller->check_action('send') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$uid = isset($_GET['uid'])? intval($_GET['uid']) : '';
	//if(!$uid)exit('["nouid"]');
	$userdb = $this_module->DB_master->fetch_one("SELECT username,name,cell_phone,email FROM {$this_module->core->TABLE_}member WHERE id = '$uid'");
	$shortcut_sms = $this_module->DB_master->fetch_all("SELECT id,content,timestamp FROM p8_shortcutsms_data");
	$total = array("userdb"=>$userdb,"shortcut_sms"=>$shortcut_sms);
	$json = p8_json($total);
	//$json = p8_json($userdb);
	exit($json);
	
}else if(REQUEST_METHOD == 'POST'){
	$uid = isset($_POST['uid'])? intval($_POST['uid']) : '';
	$type = isset($_POST['type'])? $_POST['type'] : '';
	$title = isset($_POST['title'])? filter_word(from_utf8($_POST['title'])) : '';
	$mobile = isset($_POST['mobile'])? filter_word($_POST['mobile']) : '';
	$semail = isset($_POST['email'])? filter_word($_POST['email']) : '';
	$content = isset($_POST['content'])? filter_word(from_utf8($_POST['content'])) : '';
	$mobile = str_replace(array(',','|','，'),',',$mobile);
	$semail = str_replace(array(',','|','，'),',',$semail);
	
	if(!$type || !$content)exit('["error"]');
	$type = explode(',', $type);
	$status1 = $status3 = $status2 = false;
	if(in_array('msg',$type)){
		$message = $this_system->load_module('message');
		$data = array(
			'uid' => $uid,
			'title' => $title,
			'content' => $content
		);
		$status1 = $message->send($data);
	}
	if(in_array('sms',$type) || $mobile){
		$userdb = $this_module->DB_master->fetch_one("SELECT cell_phone FROM {$this_module->core->TABLE_}member WHERE id = '$uid'");
		$sendto = $userdb['cell_phone'] .','. $mobile;
		$sendto = ltrim($sendto,',');
		$sendto = rtrim($sendto,',');
		
		$sms = &$core->load_module('sms');
		$sms_content = str_replace(array("\t"), '', strip_tags($content));
		if($sendto){
			$status2 = $sms->send(
				$sendto,
				$sms_content
			);
		}
	} 
	if(in_array('email',$type) || $semail){
		$userdb = $this_module->DB_master->fetch_one("SELECT email FROM {$this_module->core->TABLE_}member WHERE id = '$uid'");
		$sendto = $userdb['email'] .','. $semail;
		$sendto = ltrim($sendto,',');
		$sendto = rtrim($sendto,',');
		$email = &$core->load_module('mail');
		$sendto = explode(',', $sendto);
		foreach($sendto as $send){
				$email->set(array(
					'subject' => $title,
					'message' => $content,
					'send_to' => $send
				));
			$status3 = $email->send();
		}
	}
	if(!$status1 && !$status2 && !$status3)exit('["error"]');
	exit("['ok']");
}