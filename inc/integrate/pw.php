<?php
defined('PHP168_PATH') or die();

class P8_Integrate_pw{

var $core;
var $CONFIG;
var $db;

function __construct(&$core){
	$this->core = &$core;
	
	isset($core->CONFIG['integration']['config']) or die('PW!');

	$this->CONFIG = &$core->CONFIG['integration']['config'];
	
}

function P8_Integrate_pw(&$core){
	$this->__construct($core);
}

/**
 用户登录
  @param  string $username   - 用户名
  @param  string $pwd        - 密码(md5)
  @param  int $logintype     - 登录类型 0,1,2分别为 用户名,uid,邮箱登录
  @param  boolean $checkques - 是否要验证安全问题
  @param  string $question   - 安全问题
  @param  string $answer     - 安全回答
  @return array 同步登录的代码
*/
function login($username, $password){
	
	$ret = array(
		'status' => 0,
		'id' => 0,
		'username' => '',
		'password' => '',
		'email' => '',
		'message' => '',
	);
	
	//本系统自己登录
	$data = get_member($username);

	//用户不存在
	if(empty($data)){
		$ret['status'] = -1;
		return $ret;
	}
	
	if($data['password'] != md5($password . $data['salt'])){
		$ret['status'] = -2;
		return $ret;
	}
	
	$userdb = array(
		'username' => $username,
		'password' => $password,
		'time' => P8_TIME
	);
	
	$userdb_encode = $this->userdb($userdb);
	
	global $HTTP_REFERER;
	
	$forward = $HTTP_REFERER;
	if(preg_match('/forward=(.+)/', $forward, $m)){
		$forward = urldecode($m[1]);
	}
	$verify = md5('login'. $userdb_encode . $forward . $this->CONFIG['code']);
	
	$ret['id'] = $data['id'];
	$ret['message'] = '<script type="text/javascript">window.location.href= \''.
		$this->CONFIG['api'] .'/passport_client.php?action=login&userdb='. urlencode($userdb_encode) .'&forward='. urlencode($forward) .'&verify='. urlencode($verify) 
	.'\';</script>';
	
	return $ret;
}

function logout(){
	
	global $USERNAME, $HTTP_REFERER;
	
	$userdb = array(
		'username' => $USERNAME,
		'password' => 'none',
		'time' => P8_TIME
	);
	
	$userdb_encode = $this->userdb($userdb);
	
	$forward = $HTTP_REFERER;
	$verify = md5('quit'. $userdb_encode . $forward . $this->CONFIG['code']);
	
	return '<script type="text/javascript">window.location.href= \''.
		$this->CONFIG['api'] .'/passport_client.php?action=quit&userdb='. rawurlencode($userdb_encode) .'&forward='. rawurlencode($forward) .'&verify='. rawurlencode($verify) 
	.'\';</script>';
}

/**
 注册
  @param  string $username - 注册用户名
  @param  string $password - 注册密码(md5)
  @param  string $email	   - 邮箱
  @return int 注册用户uid
  -1 用户名不合法
  -2 用户名己存在
  -3 email不合法
  -4 email被注册
*/
function register($username, $password, $email){
	//$member = &$this->core->load_module('member');
	
	
	if(($status = $this->check_username($username)) != 0){
		return $status;
	}
	
	if(($status = $this->check_email($email)) != 0){
		return $status;
	}
	
	$data = array(
		'username' => $username,
		'password' => $password,
		'email' => $email
	);
	$id = $this->DB_master->insert($this->core->member_table, $data, array('return_id' => true));
	
	if($id){
		
		//eggache
		$this->DB_master->delete(
			$this->core->member_table,
			"id = '$id'"
		);
		
		return $id;
	}
	
	return -4;
}

function check_email($email){
	return $this->DB_master->fetch_one("SELECT id FROM {$this->core->member_table} WHERE email = '$email'") ? -2 : 0;
}

function check_username($username){
	//没整合
	if(!preg_match('/^\w{4,}/', $username)){
		return -1;
	}
	
	$member = &$this->core->load_module('member');
	
	//禁止注册的会员,管理员添加或站群添加的忽略
	global $IS_ADMIN;
	if(!empty($member->CONFIG['reg_disallow_username']) && !($IS_ADMIN || defined('P8_CLUSTER'))){
		$disallow = trim($member->CONFIG['reg_disallow_username']);
		$tmp = array_filter(explode('|', $disallow));
		$disallow = implode('|', $tmp);
		
		if(preg_match('/^('. $disallow .')/i', $username)){
			return -1;
		}
	}
	
	return get_member($username) ? -2 : 0;
}

function delete_member($ids){
	return true;
}

function passwd($username, $password, $old_password = ''){
	return 0;
}






function userdb(&$userdb){
	
	$userdb_encode = '';
	foreach($userdb as $key=>$val)
	{
		$userdb_encode .= $userdb_encode ? "&$key=$val" : "$key=$val";
	}
	return str_replace('=', '', $this->StrCode($userdb_encode));
}

function StrCode($string,$action='ENCODE'){
	$key	= substr(md5(USER_AGENT . $this->CONFIG['code']),8,18);
	$string	= $action == 'ENCODE' ? $string : base64_decode($string);
	$len	= strlen($key);
	$code	= '';
	$_len = strlen($string);
	for($i=0; $i<$_len; $i++)
	{
		$k		= $i % $len;
		$code  .= $string[$i] ^ $key[$k];
	}
	$code = $action == 'DECODE' ? $code : base64_encode($code);
	return $code;
}

}