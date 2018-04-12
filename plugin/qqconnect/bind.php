<?php
defined('PHP168_PATH') or die();
load_language($this_plugin, 'global');
if(REQUEST_METHOD == 'GET'){
	$b = isset($_GET['b'])? 1 : 0;
	if($b && $UID && $this_plugin->access_token){
		if($this_plugin->bind())
			message('bind_success',$core->url);
	}elseif($this_plugin->access_token){
		$forward = urlencode($this_url.'?b=1');
		$core->get_cache('role_group');
		$groups = $core->role_groups;
		include $this_plugin->template('bind');
	}else{
		$this_plugin->qq_login();
	}
}elseif(REQUEST_METHOD == 'POST'){
	
	$type = $_POST['type'];
	if($type==1){
		
		$username = isset($_POST['username'])? html_entities($_POST['username']) : '';
		$password = isset($_POST['password'])? html_entities($_POST['password']) : '';
		if(!$username || !$password)
			message('user_must');
			
		$data = get_member($username);
		
		//用户不存在
		if(empty($data)){
			message('no_such_user');
		}elseif($data['status']!=0){
			message('member_locked');
		}
		
		$flag = false;
		if($data['password'] == md5(md5($password) . $data['salt']))
			$flag = true;
		elseif($data['password'] == md5($password . $data['salt']))//兼容之前的
			$flag = true;
		
		if(!$flag)
			message('wrong_password');
		
		if($this_plugin->bind($data)){
			$this_plugin->login($data,false);
			unset($_P8SESSION['qqconnect_data'],$_P8SESSION['qqconnect_state']);
			message('bind_success',$core->url);
		}
		message('error');
			
	}else if($type==2){
	
		$member = $core->load_module('member');
		$member_controller= $core->controller($member);

		if($member_controller->check_username($_GET['data'])!==0){
			message('user_exists');
		}
		if($member_controller->check_email($_GET['data'])!==0){
			message('mail_exists');
		}
		$gid = isset($_POST['gid']) ? intval($_POST['gid']) : 0;
		$core->get_cache('role_group');
		
		//角色组不允许注册
		if(
			$gid == 0 ||
			$gid != 0 && (empty($core->role_groups[$gid]['registrable']) || empty($core->role_groups[$gid]['default_role']))
		) message('access_denied');
		$this_model = &$member->get_model($gid);
	
		$qdata = $this_plugin->get_qq_user_info();
		$_POST['name'] = html_entities(from_utf8($qdata['nickname']));
		$_POST['role_id'] = $core->role_groups[$gid]['default_role'];
		$_POST['role_gid'] = $gid;
		unset($_POST['is_founder'], $_POST['is_admin']);
		$id = $member_controller->register($_POST);
		
		if(!$id)message('error');
		
		$data = get_member($id, false ,'id');
		
		if($this_plugin->bind($data)){
			$this_plugin->login($data,false);
			
			unset($_P8SESSION['qqconnect_data'],$_P8SESSION['qqconnect_state']);

			message('bind_success',$core->url);
		}
		message('error');
	}
}
?>