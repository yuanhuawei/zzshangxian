<?php
/**
* ����API,�����
**/

require dirname(__FILE__) .'/../inc/init.php';

//define('P8_KEY', 'yourkey');			//ͨ������
define('P8_API_TEST_OK',			'1');	//����
define('P8_API_ACCESS_DENIED',		'0');	//�ܾ�����
define('P8_API_AUTH_FAIL',			'-1');	//��֤ʧ��
define('P8_API_NO_ACTION',			'-2');	//û�ж���
define('P8_API_SERVER_ID_ERROR',	'-3');	//������ID����
define('P8_API_EXPIRE',				'-4');	//��֤����
define('P8_API',					$core->url . PHP_SELF);	//��ַ
define('P8_API_SERVER_ID',			$core->CONFIG['server_id']);	//������ID

defined('P8_API_DATA_NAME') or define('P8_API_DATA_NAME', 'p8_api_data');	//��������

isset($_REQUEST[P8_API_DATA_NAME]) or die(P8_API_ACCESS_DENIED);

//����
$data = @mb_unserialize(p8_code($_REQUEST[P8_API_DATA_NAME], false));

//����Ϊ��,��֤ʧ��
if(empty($data)){
	die(P8_API_AUTH_FAIL);
}

/*
//������ID����
if(empty($core->CONFIG['passport_applications'][$data['server_id']])){
	die(P8_API_SERVER_ID_ERROR);
} */

isset($data['action']) or die(P8_API_NO_ACTION);

P8_TIME - @$data['time'] < 120 or die(P8_API_EXPIRE);

switch($data['action']){

	case 'test':
		//������ͨ
		exit(P8_API_TEST_OK);
	break;
	
	case 'updateapps':
		exit(API_RETURN_SUCCEED);
	break;
	
	case 'set_config':
		//ͬ������
		$system = empty($data['system']) ? '' : $data['system'];
		$module = empty($data['module']) ? '' : $data['module'];
		//ϵͳ������
		if($system != 'core' && !get_system($system)) die();
		
		if($system == 'core'){
			$this_system = &$core;
		}else{
			$this_system = &$core->load_system($system);
		}
		
		if($module){
			//ģ�鲻����
			get_module($system, $module) or die();
			
			$this_module = &$this_system->load_module($module);
			$this_module->set_config(array());
		}else{
			$this_system->set_config(array());
		}
		
	break;
	
	case 'cache':
		//ͬ������
		$system = empty($data['system']) ? '' : $data['system'];
		$module = empty($data['module']) ? '' : $data['module'];
		
		//ϵͳ������
		if($system != 'core' && !get_system($system)) die();
		
		if($system == 'core'){
			$this_system = &$core;
		}else{
			$this_system = &$core->load_system($system);
		}
		
		if($module){
			//ģ�鲻����
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
		//����û���
		$member = &$core->load_module('member');
		
		exit((string)$member->check_username(isset($data['username']) && strlen($data['username']) ? $data['username'] : ''));
	break;
	
	case 'register':
		//ע���Ա
		$member = &$core->load_module('member');
		$username = isset($data['username']) && strlen($data['username']) ? $data['username'] : '';
		$password = isset($data['password']) && strlen($data['password']) ? $data['password'] : '';
		$email = isset($data['email']) && strlen($data['email']) ? $data['email'] : '';
		
		exit((string)$member->register($username, $password, $email));
	break;
	
	case 'passwd':
		//�޸�����
		$member = &$core->load_module('member');
		
		if(empty($data['ignore_old'])){
			//�������������Ϳ��Ը�
			$ret = $member->change_password(
				isset($data['id']) ? $data['id'] : 0,
				isset($data['new_password']) ? $data['new_password'] : ''
			);
		}else{
			//��Ҫ������
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
		//��Ա��¼,�������ж��û����������Ƿ���ȷ,ͬ����¼��Ҫ�ٴ�����syn_login
		$member = &$core->load_module('member');
		
		//��Ҫ�û�������
		$ret = $member->login(
			isset($data['username']) && strlen($data['username']) ? $data['username'] : '',
			isset($data['password']) && strlen($data['password']) ? $data['password'] : '',
			0,
			true
		);
		
		$ret['status'] == 0 or exit(serialize($ret));
		
		//֪ͨ�����ͻ���ȥͬ����¼
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
		//ͬ����¼
		$member = &$core->load_module('member');
		
		//ob_clean();
		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
		//ֻ�贫���û������û�ID����
		$member->login(
			isset($data['username']) && strlen($data['username']) ? $data['username'] : '',
			'',
			empty($data['id']) ? 0 : $data['id']
		);
	break;
	
	case 'logout':
		//�˳�,ֻ�ǹ����˳�������,��Ҫ�ٴε���syn_logout�����˳�
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
		//ͬ���˳�
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