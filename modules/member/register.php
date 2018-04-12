<?php
defined('PHP168_PATH') or die();

header('Pragma: no-cache');
header('Cache-Control: no-cache, must-revalidate');

if(($inte = &$core->integrate()) && !empty($inte->CONFIG['client'])){
	header('HTTP/1.1 301 Moved Permanently');
	header('Location: '. $inte->CONFIG['api'] .'/'. $inte->CONFIG['register_url'] /*.'&forward='. urlencode(isset($_GET['forward']) ? $_GET['forward'] : $core->U_controller)*/);
	exit;
}

if(empty($this_module->CONFIG['register']['enabled'])) message('register_disabled');

load_language($this_module, 'register');

if(REQUEST_METHOD == 'GET'){
	
	if(!empty($this_module->CONFIG['register_question_enabled'])){
		//需要验证码,产生一条问题
		$question = $this_module->verify_question();
	}
	
	$gid = isset($_GET['gid']) ? intval($_GET['gid']) : 0;
	
	$core->get_cache('role_group');
	$groups = $core->role_groups;
	
	if($gid != 0 && (empty($core->role_groups[$gid]['registrable']) || empty($core->role_groups[$gid]['default_role']))) message('access_denied');
	
	foreach($core->role_groups as $k => $v){
		if(!$v['registrable'] || !$v['default_role']) unset($core->role_groups[$k]);
	}
	
	if(!$gid && count($core->role_groups) == 1){
		header('Location: '. $this_url .'?&gid='. array_rand($core->role_groups) .'&'. $_SERVER['QUERY_STRING']);
		exit;
	}
	
	$this_model = &$this_module->get_model($gid);

	$_SERVER['QUERY_STRING'] = xss_url($_SERVER['QUERY_STRING']);
	
	include template($this_module, 'register', 'default');
	
}else if(REQUEST_METHOD == 'POST'){
	
	//需要注册问题
	if(!empty($this_module->CONFIG['register']['question_enabled'])){
		$q = $_POST['register_question'] ? $_POST['register_question'] : '';
		
		$this_module->verify_question($q) or message('verify_question_incorrect', HTTP_REFERER, 10);
	}
	
	if(!empty($this_module->CONFIG['register']['captcha']) && !captcha(isset($_POST['captcha']) ? $_POST['captcha'] : '')){
		message('captcha_incorrect', HTTP_REFERER, 10);
	}
	
	
	//同意条款, 在模板处, 提交__agreement已经被加密
	if(empty($_POST['__agreement'])) message('agreement');
	
	$password = isset($_POST['password']) ? $_POST['password'] : '';
	$confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
	
	if(!strlen($password)){
		message('password_required');
	}
	
	if($password !== $confirm_password){
		message('password_not_match');
	}
	
	$gid = isset($_POST['gid']) ? intval($_POST['gid']) : 0;
	$core->get_cache('role_group');
	
	//角色组不允许注册
	if(
		$gid == 0 ||
		$gid != 0 && (empty($core->role_groups[$gid]['registrable']) || empty($core->role_groups[$gid]['default_role']))
	) message('access_denied');
	
	$this_model = &$this_module->get_model($gid);
	
	$_POST['role_id'] = $core->role_groups[$gid]['default_role'];
	$_POST['role_gid'] = $gid;
	unset($_POST['is_founder'], $_POST['is_admin']);
	
	$id = $this_controller->register($_POST);
	
	if($id>0){
		if($this_module->CONFIG['register']['verify']){//邮件验证
			$message = $this_module->CONFIG['register']['verify'] ==1? $P8LANG['email_verify_message'] : $P8LANG['man_verify_message'];
			include template($this_module, 'register_message', 'default');
		}else{
			$ret = $this_module->login(html_entities($_POST['username']), $password);
	
			message($P8LANG['done'] . $ret['message'], empty($_POST['forward']) ? $this_module->U_controller : xss_url($_POST['forward']));
		}
	}else{
		message('fail');
	}
	
	
}