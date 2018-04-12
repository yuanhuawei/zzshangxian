<?php
defined('_P8_KEY') or die();

//时间戳
defined('P8_TIME') or define('P8_TIME', time());

/**
* 登录
* @param $username 用户名
* @param $password 密码
* @return array array(status => 状态, id => 用户ID, email => 邮箱)
**/
function p8_member_login($username, $password){
	$data = array(
		'action' => 'login',
		'username' => $username,
		'password' => $password
	);
	
	$ret = @mb_unserialize(_p8_post_api_data($data));
	empty($ret) && $ret = array('status' => -3, 'id' => 0, 'email' => '');	//未知错误
	return $ret;
}

function p8_member_logout(){
	$data = array(
		'action' => 'syn_logout'
	);
	
	return _p8_post_api_data($data);
}

function p8_member_check($username){
	$data = array(
		'action' => 'check_member',
		'username' => $username
	);
	
	return _p8_post_api_data($data);
}

/**
* 会员注册
**/
function p8_member_register($username, $password, $email){
	$data = array(
		'action' => 'register',
		'username' => $username,
		'password' => $password,
		'email' => $email
	);
	
	return _p8_post_api_data($data);
}

function p8_change_password($uid, $old, $new, $confirm = '', $ignore_old = false){
	$data = array(
		'action' => 'passwd',
		'id' => $uid,
		'old_password' => $old,
		'new_password' => $new,
		'confirm_password' => $confirm,
		'ignore_old' => $ignore_old
	);
	
	return _p8_post_api_data($data);
}

function p8_member_delete($ids){
	$data = array(
		'action' => 'delete_member',
		'ids' => $ids
	);
	
	return _p8_post_api_data($data);
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

/**
* 传递数据并返回
**/
function _p8_post_api_data($data){
	//时间
	$data['time'] = P8_TIME;
	//服务器ID
	$data['server_id'] = _P8_API_SERVER_ID;
	
	$ret = p8_http_request(
		_P8_API,
		_P8_API_DATA_NAME .'='. urldecode(_p8_code(serialize($data))),
		'',
		_P8_API_IP
	);
	return $ret['body'];
}

/**
* HTTP请求
**/
if(!function_exists('p8_http_request')){

function p8_http_request($url, $post = '', $limit = 0, $cookie = '', $ip = '', $timeout = 15, $block = true){
	$return = '';
	$p = parse_url($url);
	$host = $p['host'];
	$path = $p['path'] ? $p['path'] . (isset($p['query']) ? '?'.$p['query'] : '') : '/';
	$port = !empty($p['port']) ? $p['port'] : 80;

	if($post){
		$r = "POST $path HTTP/1.1\r\n";
		$r .= "Accept: */*\r\n";
		$r .= "Accept-Language: zh-cn\r\n";
		$r .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$r .= "User-Agent: {$_SERVER['HTTP_USER_AGENT']}\r\n";
		$r .= "Host: $host\r\n";
		$r .= "Content-Length: ".strlen($post)."\r\n";
		$r .= "Connection: Close\r\n";
		$r .= "Cache-Control: no-cache\r\n";
		$r .= "Cookie: $cookie\r\n\r\n";
		$r .= $post;
	}else{
		$r = "GET $url HTTP/1.1\r\n";
		$r .= "Host: $host\r\n";
		$r .= "User-Agent: {$_SERVER['HTTP_USER_AGENT']}\r\n";
		$r .= "Accept: */*\r\n";
		$r .= "Accept-Language: zh-cn\r\n";
		//$r .= "Accept-Encoding: gzip,deflate\r\n";
		//$r .= "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7\r\n";
		//$r .= "Keep-Alive: 300\r\n";
		//$r .= "Referer: \r\n";
		$r .= "Connection: close\r\n";
		$r .= "Cookie: $cookie\r\n\r\n";
	}
	
	$fp = @fsockopen($ip ? $ip : $host, $port, $errno, $errstr, $timeout);
	if(!$fp){
		return '';
	}else{
		stream_set_blocking($fp, $block);
		stream_set_timeout($fp, $timeout);
		@fwrite($fp, $r);
		$status = stream_get_meta_data($fp);
		if(empty($status['timed_out'])){
			while (!feof($fp)){
				if(($header = @fgets($fp)) && ($header == "\r\n" ||  $header == "\n")) {
					break;
				}
			}

			$stop = false;
			while(!feof($fp) && !$stop){
				$data = fread($fp, ($limit == 0 || $limit > 8192 ? 8192 : $limit));
				$return .= $data;
				if($limit) {
					$limit -= strlen($data);
					$stop = $limit <= 0;
				}
			}
		}
		@fclose($fp);
		return $return;
	}
}

}