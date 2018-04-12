<?php
/**
* 整合API,服务端
**/

require dirname(__FILE__) .'/../inc/init.php';

//define('P8_KEY', 'yourkey');			//通信密码
define('P8_API_TEST_OK',			'1');	//测试
define('P8_API_ACCESS_DENIED',		'0');	//拒绝访问
define('P8_API_AUTH_FAIL',			'-1');	//验证失败
define('P8_API_NO_ACTION',			'-2');	//没有动作
define('P8_API_SERVER_ID_ERROR',	'-3');	//服务器ID错误
define('P8_API_EXPIRE',				'-4');	//验证过期
define('P8_API',					$core->url . PHP_SELF);	//地址
define('P8_API_SERVER_ID',			$core->CONFIG['server_id']);	//服务器ID

defined('P8_API_DATA_NAME') or define('P8_API_DATA_NAME', 'p8_api_data');	//数据名称

isset($_REQUEST[P8_API_DATA_NAME]) or die(P8_API_ACCESS_DENIED);

//解密
$data = @mb_unserialize(p8_code($_REQUEST[P8_API_DATA_NAME], false));

//数据为空,验证失败
if(empty($data)){
	die(P8_API_AUTH_FAIL);
}

/*
//服务器ID错误
if(empty($core->CONFIG['passport_applications'][$data['server_id']])){
	die(P8_API_SERVER_ID_ERROR);
} */

isset($data['action']) or die(P8_API_NO_ACTION);

P8_TIME - @$data['time'] < 120 or die(P8_API_EXPIRE);

switch($data['action']){

	case 'test':
		//测试连通
		exit(P8_API_TEST_OK);
	break;
	
	case 'updateapps':
		exit(API_RETURN_SUCCEED);
	break;
	
	case 'set_config':
		//同步配置
		$system = empty($data['system']) ? '' : $data['system'];
		$module = empty($data['module']) ? '' : $data['module'];
		//系统不存在
		if($system != 'core' && !get_system($system)) die();
		
		if($system == 'core'){
			$this_system = &$core;
		}else{
			$this_system = &$core->load_system($system);
		}
		
		if($module){
			//模块不存在
			get_module($system, $module) or die();
			
			$this_module = &$this_system->load_module($module);
			$this_module->set_config(array());
		}else{
			$this_system->set_config(array());
		}
		
	break;
	
	case 'cache':
		//同步缓存
		$system = empty($data['system']) ? '' : $data['system'];
		$module = empty($data['module']) ? '' : $data['module'];
		
		//系统不存在
		if($system != 'core' && !get_system($system)) die();
		
		if($system == 'core'){
			$this_system = &$core;
		}else{
			$this_system = &$core->load_system($system);
		}
		
		if($module){
			//模块不存在
			get_module($system, $module) or die();
			
			$this_module = &$this_system->load_module($module);
			$this_module->cache();
		}
	break;
	
	case 'syn_session':
		$session_id = isset($data['session_id']) ? $data['session_id'] : '';
		
		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
		
		if(empty($_COOKIE[SESSION_NAME]) && $session_id)
			setcookie(SESSION_NAME, $session_id, 0, '/');
	break;
	
	case 'check_member':
		//检查用户名
		$member = &$core->load_module('member');
		
		exit((string)$member->check_username(isset($data['username']) && strlen($data['username']) ? $data['username'] : ''));
	break;
	
	case 'register':
		//注册会员
		$member = &$core->load_module('member');
		$username = isset($data['username']) && strlen($data['username']) ? $data['username'] : '';
		$password = isset($data['password']) && strlen($data['password']) ? $data['password'] : '';
		$email = isset($data['email']) && strlen($data['email']) ? $data['email'] : '';
		
		exit((string)$member->register($username, $password, $email));
	break;
	
	case 'passwd':
		//修改密码
		$member = &$core->load_module('member');
		
		if(empty($data['ignore_old'])){
			//无须输入旧密码就可以改
			$ret = $member->change_password(
				isset($data['id']) ? $data['id'] : 0,
				isset($data['new_password']) ? $data['new_password'] : ''
			);
		}else{
			//需要旧密码
			$controller = &$core->controller($member);
			
			$ret = $controller->change_password(
				isset($data['id']) ? $data['id'] : 0,
				isset($data['old_password']) ? $data['old_password'] : '',
				isset($data['new_password']) ? $data['new_password'] : '',
				isset($data['confirm_password']) ? $data['confirm_password'] : ''
			);
		}
		exit((string)$ret);
	break;
	
	case 'login':
		//会员登录,仅仅是判断用户名和密码是否正确,同步登录需要再次请求syn_login
		$member = &$core->load_module('member');
		
		//需要用户和密码
		$ret = $member->login(
			isset($data['username']) && strlen($data['username']) ? $data['username'] : '',
			isset($data['password']) && strlen($data['password']) ? $data['password'] : '',
			0,
			true
		);
		
		$ret['status'] == 0 or exit(serialize($ret));
		
		//通知各个客户端去同步登录
		$img = '';
		foreach($core->CONFIG['passport_applications'] as $client_id => $app){
			$hash = urlencode(
				p8_code(
					serialize(array(
						'action' => 'syn_login',
						'server_id' => $client_id,
						'username' => $data['username'],
						'id' => $ret['id'],
						'time' => P8_TIME
					)),
					true,
					$app['key']
				)
			);
			$img .= '<img style="display: none;" src="'. $app['api'] .'?'. P8_API_DATA_NAME .'='. $hash .'"></img>';
		}
		
		$ret['message'] = $img;
		exit(serialize($ret));
	break;
	
	case 'syn_login':
		//同步登录
		$member = &$core->load_module('member');
		
		//ob_clean();
		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
		//只需传入用户名和用户ID即可
		$member->login(
			isset($data['username']) && strlen($data['username']) ? $data['username'] : '',
			'',
			empty($data['id']) ? 0 : $data['id']
		);
	break;
	
	case 'logout':
		//退出,只是构造退出的数据,需要再次调用syn_logout才能退出
		$_data = serialize(array(
			'action' => 'syn_logout',
			'time' => P8_TIME
		));
		
		$img = '';
		foreach($core->CONFIG['passport_applications'] as $client_id => $app){
			$hash = urlencode(
				p8_code(
					serialize(array(
						'action' => 'syn_logout',
						'server_id' => $client_id,
						'time' => P8_TIME
					)),
					true,
					$app['key']
				)
			);
			$img .= '<img style="display: none;" src="'. $app['api'] .'?'. P8_API_DATA_NAME .'='. $hash .'"></img>';
		}
		
		exit($img);
		
	break;
	
	case 'syn_logout':
		//同步退出
		$member = &$core->load_module('member');
		
		//ob_clean();
		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
		$member->logout();
	break;
	
	case 'delete_user':
		$member->delete(array(
			'where' => $member->table .'.id IN ('. $data['ids'] .')'
		));
		
	break;
}