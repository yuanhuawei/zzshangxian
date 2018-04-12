<?php
defined('PHP168_PATH') or die();

/**
* µÇÂ¼
**/

if(($inte = &$core->integrate()) && !empty($inte->CONFIG['client'])){
	header('HTTP/1.1 301 Moved Permanently');
	header('Location: '. $inte->CONFIG['api'] .'/'. $inte->CONFIG['login_url'] /*.'&forward='. urlencode(isset($_GET['forward']) ? $_GET['forward'] : $core->U_controller)*/);
	exit;
}

if(REQUEST_METHOD == 'GET'){
	//Ç°Ì¨µÇÂ¼¿ò
	
	if(isset($_GET['username']) || isset($_GET['password'])){
		exit('attack');
	}
	$style = !empty($_GET['style']) ? xss_clear($_GET['style']) : '';
	if($style){
		include "loginstyle.php";
		exit;
	}
	if($UID){
		header('Location: '. $core->U_controller);
		exit;
	}
	if(isset($_GET['forward'])){
		$forward = html_entities($_GET['forward']);
	}else if(isset($forward)){
		
	}else{
		$forward = $this_module->U_controller;
	}
	
	include template($this_module, 'login', 'member/default');
	
}else if(REQUEST_METHOD == 'POST'){
	if(P8_AJAX_REQUEST)$_POST = from_utf8($_POST);
	if(!empty($this_module->CONFIG['login_with_captcha'])){
		captcha(isset($_POST['captcha']) ? $_POST['captcha'] : '') or message('captcha_incorrect');
	}
	
	$forward = empty($_POST['forward']) ? $core->U_controller : xss_url($_POST['forward']);
	$type = isset($_POST['type'])? $_POST['type'] : 'username';
	if(isset($_POST['username']) && isset($_POST['password'])){
		$_POST['username'] = p8_addslashes2($_POST['username']);
		$data = $this_module->login($_POST['username'], $_POST['password'], 0, false, $type);
		switch($data['status']){
			case 0:
				if(P8_AJAX_REQUEST)exit(p8_json($data));				
				message(p8lang($P8LANG['login_success'],$forward). $data['message'], $forward, 5);
			break;
			case 1:
				if(P8_AJAX_REQUEST)exit("['user_no_verify']");
				message($P8LANG['user_no_verify'] . $data['message'], $forward, 5);
			break;
			case -1:
				if(P8_AJAX_REQUEST)exit("['no_such_username']");
				message('no_such_username', HTTP_REFERER);
			break;
			
			case -2:
				if(P8_AJAX_REQUEST)exit("['wrong_password']");
				message('wrong_password', HTTP_REFERER);
			break;
		}
	}
	
}