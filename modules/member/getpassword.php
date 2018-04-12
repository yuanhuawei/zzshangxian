<?php
defined('PHP168_PATH') or die();
if(REQUEST_METHOD == 'GET'){
	$forward = empty($_GET['forward']) ? $core->controller .'/core/member' : xss_url($_GET['forward']);
	$getpaswdurl=$core->controller .'/core/member-getpassword';
	$check_type=isset($_GET['check_type'])? p8_addslashes($_GET['check_type']):'';
	$email=isset($_GET['email'])?p8_addslashes(p8_html_filter($_GET['email'])):'';
	$checkcode=isset($_GET['checkcode'])?p8_addslashes(p8_html_filter($_GET['checkcode'])):'';
	//ajax操作

	switch($check_type){
		case 'email':
			if(!captcha($_GET['captcha'],true))exit('captcha');
			if(-2==$this_controller->check_email($email)){
				echo "true";
			}else{
				echo "false";
			}
			exit;
		case 'checkcode':
			$result=$DB_master->query("SELECT * FROM $this_module->getpasswd_table WHERE email='$email' AND checkcode='$checkcode'");
			if($row=mysql_fetch_array($result,MYSQL_ASSOC)){
				if(get_timer()-$row['createtime']>$row['invalidlong']){
					echo "false";
				}else{
					echo "true";
				}
			}else{
				echo "false";
			}
			exit;
		default:
			include template($this_module, 'getpasword_first');
	}

}else{
	$passwd_data = isset($_POST['passwd_data']) && is_array($_POST['passwd_data']) ? $_POST['passwd_data'] : array();
	if(!isset($passwd_data['step'])){
		message('error');
		exit;
	}
	switch($passwd_data['step']){
		case 'second':
			if(!captcha($_POST['captcha'])){message('验证码错误!');exit;}
			$email=p8_addslashes(p8_html_filter($passwd_data['email']));
			if(-2==$this_controller->check_email($email)){
				$mail = &$core->load_module('mail');
				$checkcode='';
				for($i=0;$i<6;$i++){
					$checkcode.=rand(0,9);
				}
				$time_long = empty($this_module->CONFIG['checkcode_timelong']) ? 3600 : $this_module->CONFIG['checkcode_timelong'];
				$subject="密码找回";
				$message="您的验证码为:<font color='red'>$checkcode</font><br>";
				$DB_master->query("DELETE FROM $this_module->getpasswd_table WHERE email='$email'");
				$result=$DB_master->query("INSERT INTO $this_module->getpasswd_table VALUES(NULL,'$email','$checkcode',".get_timer().",$time_long)");
				if(!$result){
					message('邮件发送失败!');
					exit;
				}
				$mail->set(array("subject"=>"$subject","message"=>"$message","send_to"=>"$email"));
				if(false===$mail->send()){
					message('邮件发送失败!');
					exit;
				}
			}else{
				message('邮件格式出错，或不存在!');
				exit;
			}
			include template($this_module, 'getpasword_second');
			break;
		case 'third':
			$passwd_data['email'] = p8_html_filter($passwd_data['email']);
			include template($this_module, 'getpasword_third');
			break;
		case 'last':
			if(empty($passwd_data['passwd1'])||empty($passwd_data['passwd2'])||empty($passwd_data['email'])||empty($passwd_data['checkcode'])||$passwd_data['passwd1']!==$passwd_data['passwd2']){
				message('修改密码失败!');
				exit;
			}
			$email=p8_addslashes(p8_html_filter($passwd_data['email']));
			$checkcode=p8_addslashes(p8_html_filter($passwd_data['checkcode']));
			$result=$DB_master->query("SELECT * FROM $this_module->getpasswd_table WHERE email='$email' AND checkcode='$checkcode'");
			if($row=mysql_fetch_array($result,MYSQL_ASSOC)){
				if(get_timer()-$row['createtime']>$row['invalidlong']){
					message('修改密码失败!');
					exit;
				}
			}else{
				message('修改密码失败!');
				exit;
			}
			$new=$passwd_data['passwd1'];
			$salt = rand_str(4);
			if($DB_master->update(
			$this_module->table,
			array(
			'password' => md5($new . $salt),
			'salt' => $salt
			),
			"email = '$email'"
			)){
				message('密码更改成功!');
				exit;
			}
			message('密码更改失败!');
			break;
		default:
			header("Location: $getpaswdurl");
	}
}

?>