<?php
defined('PHP168_PATH') or die();
load_language($this_plugin, 'global');
$act = isset($_GET['code'])? 'c' : 'l';
if($act=='l'){	//login
	$this_plugin->qq_login();
}elseif($act == 'c'){ //callback
	if(!$this_plugin->callback($_GET))
		message('error',$core->url, 3);
	$bind_info = $this_plugin->get_bind_info();
	if(!$bind_info){
		$this_plugin->mark_session();
		$core->get_cache('role_group');
		$groups = $core->role_groups;
		$forward=$forward = urlencode($this_router.'-bind?b=1');
		
		if($this_plugin->CONFIG['check_status']){
			include $this_plugin->template('bind');
		}else{
			$member = $core->load_module('member');
			$member_controller= $core->controller($member);
			$qdata = $this_plugin->get_qq_user_info();
			
			do {
				$username = mt_rand(10000000,99999999); 
			}while ($member_controller->check_username($username));	
			
			$POST['username'] = $username;
			$POST['password'] = md5($POST['username']);
			$POST['email'] = $username.'@domain.com';
			$POST['name'] = html_entities(from_utf8($qdata['nickname']));
			$POST['role_gid'] = $this_pligin->CONFIG['role_gid'];
			$POST['role_id'] = $core->role_groups[$POST['role_gid']]['default_role'];

			$id = $UID = $member_controller->register($POST);
			$ret = $member->login($username, $POST['password']);
			
			if($UID && $this_plugin->access_token){
				if($this_plugin->bind())
					message($P8LANG['login_success'],$core->url);
			}else{
				$this_plugin->qq_login();
			}
		}
	}elseif(!$UID){
		$data = $this_plugin->login($bind_info);
		unset($_P8SESSION['qqconnect_state']);
		switch($data['status']){
			case 0:
				if(P8_AJAX_REQUEST)exit(p8_json($data));
				message($P8LANG['login_success'] . $data['message'], $core->url, 3);
			break;
			case 1:
				if(P8_AJAX_REQUEST)exit("['user_no_verify']");
				message($P8LANG['user_no_verify'] . $data['message'], $core->url, 3);
			break;
			case -1:
				if(P8_AJAX_REQUEST)exit("['no_such_user']");
				message('no_such_user', HTTP_REFERER);
			break;
			
			case -2:
				if(P8_AJAX_REQUEST)exit("['wrong_password']");
				message('wrong_password', HTTP_REFERER);
			break;
		}
	}else{
		unset($_P8SESSION['qqconnect_state']);
		message('done', $core->url);
	}
}	
?>