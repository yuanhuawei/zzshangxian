<?php
defined('PHP168_PATH') or die();

class P8_Integrate_p8{

var $core;

function P8_Integrate_p8(&$core){
	$this->core = &$core;
	
	$this->CONFIG = &$core->CONFIG['integrate']['p8'];
	
	require $this->path .'api/php168/client.php';
	
	define('_P8_KEY', $this->CONFIG['p8_key']);			//通信密码,要跟主站的一致
	define('_P8_API_DATA_NAME', 'p8_api_data');			//通信数据名称,也要跟主站的一致
	define('_P8_API', $this->CONFIG['api']);			//通信API地址
	define('_P8_API_IP', $this->CONFIG['ip']);			//通信API ip地址
	define('_P8_API_SERVER_ID', $core->CONFIG['server_id']);	//通信API ip地址
}

function login($username, $password){
	
	$ret = p8_member_login($username, $password);
	
	$ret['username'] = $username;
	$ret['password'] = $password;
	
	return $ret;
}

function logout(){
	return p8_member_logout();
}

function register($username, $password, $email){
	$status = p8_member_register($username, $password, $email);
	
	return $status;
}

function check_username($username){
	return p8_member_check($username);
}

function check_email($email){
	return p8_member_check_email($email);
}

function passwd($uid, $old, $new, $confirm){
	return p8_change_password($uid, $old, $new, $confirm);
}

function delete_member($ids){
	return p8_member_delete($ids);
}

}


/**
* 加密解密
**/
function _p8_code($string, $encode = true, $key = _P8_KEY){
	
    if($encode){
		$rand_key = substr(md5($string), 8, 4);
    }else{
        $rand_key = substr($string, -4); 
        $string = base64_decode(substr($string, 0, strlen($string) -4));
    } 
    
	$key = md5($rand_key . $key);
    $keylen = strlen($key);
	$len = strlen($string);
	$code = '';
    for($i=0; $i < $len; $i++){
        $code .= $string[$i] ^ $key{$i % $keylen};
    }
    $code = $encode ? base64_encode($code).$rand_key : (substr(md5($code), 8, 4) == $rand_key ? $code : '');
    return $code;
}