<?php
defined('PHP168_PATH') or die();

/**
* 管理员登录
**/

if(!$this_controller->check_admin_action($ACTION)){
	
	//message('你的角色不允许登录后台', $core->U_controller .'/core/member-login?forward='. urlencode($this_router));
}

if(REQUEST_METHOD == 'GET'){
	
	include template($core, 'login', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$username = isset($_POST['username']) ? html_entities($_POST['username']) : '';
	
    if(!empty($core->CONFIG['admin_login_false'])){
        $alfData = $core->CACHE->read('', 'core', 'admin_login_false');

        if(isset($alfData[$username]) 
            && $alfData[$username]['count']>= intval($core->CONFIG['admin_login_false']) 
            && $alfData[$username]['last']> P8_TIME - intval($core->CONFIG['admin_login_false_lock'])*60){
                
            message(p8lang($P8LANG['admin_login_false'],$core->CONFIG['admin_login_false'],$core->CONFIG['admin_login_false_lock'])); 
        }
    }
    
	 if(
		!empty($core->CONFIG['admin_login_with_captcha']) &&
		!captcha(isset($_POST['captcha']) ? $_POST['captcha'] : '')
	) message('captcha_incorrect'); 
	
	if(
		!empty($core->CONFIG['admin_login_code']) &&
		(isset($_POST['code']) ? $_POST['code'] : '') != $core->CONFIG['admin_login_code']
	) message('admin_login_code_incorrect');
	
	if(isset($_POST['password'])){
		$member = &$core->load_module('member');
		
		$data = $member->login($username, $_POST['password']);
		
		switch($data['status']){
			case 0:
				$_P8SESSION['#admin_login#'] = 1;
				//设置SESSION即算登录后台
				admin_login_false($username);
				message($P8LANG['login_success'] . $data['message'], empty($_POST['forward']) ? $core->admin_controller : $_POST['forward'], 0);
			break;
			
			case -1:
                admin_login_false($username,false);
				message('no_such_user', HTTP_REFERER);
			break;
			
			case -2:
                admin_login_false($username,false);
				message('wrong_password', HTTP_REFERER);
			break;
		}
	}
	
}

function admin_login_false($username, $success=true){
    global $core;
    $count = intval($core->CONFIG['admin_login_false']);
    if(!$count)return;
    
    $data = $core->CACHE->read('', 'core', 'admin_login_false');
    $data = $data?$data:array();
    
    foreach($data as $name=>$row){
        if($row['last']<P8_TIME - intval($core->CONFIG['admin_login_false_lock'])*60){
            unset($data[$username]);
        }
    }
    
    if($success){
        if(empty($data[$username]))return;
        unset($data[$username]);
        
    }
    $adminlog = array();
    if(!$success){
        
        if(empty($data[$username])){
            $adminlog = array(
                'begin' => P8_TIME,
                'last' => P8_TIME,
                'count' => 1
            );
        }else{
            $adminlog = $data[$username];
            $adminlog['last'] = P8_TIME;
            $adminlog['count'] += 1;
        }
        
    }
    if($adminlog)$data[$username] = $adminlog;
    
    $core->CACHE->write('', 'core', 'admin_login_false',$data);
}