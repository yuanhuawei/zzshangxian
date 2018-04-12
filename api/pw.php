<?php
/**
* 整合PW
**/

require_once dirname(__FILE__) .'/../inc/init.php';

$request = p8_stripslashes2($_POST + $_GET);

if (isset($request['type']) && $request['type'] == 'uc') {
	$type		= 'uc';
} else {
	$type		= 'app';
}

ksort($request);
reset($request);
$arg = '';
foreach ($request as $key => $value) {
	if ($value && $key != 'sig') {
		$arg .= "$key=$value&";
	}
}

$member = &$core->load_module('member');
$config = &$member->CONFIG['pw'];
$apikey = 'php168';
$config['apikey'] = $apikey;

define('PW_APIKEY', $apikey);

if (empty($apikey) || md5($arg . $apikey) != $request['sig']) {
	exit('fail');
}

$return = array('charset' => $core->CONFIG['page_charset']);

$mode	= $request['mode'];
$method	= $request['method'];
$params = isset($request['params']) ? mb_unserialize($request['params']) : array();

switch($mode){

//网站通信
case 'Site':
	
	switch($method){
	
	case 'connect':
		exit(serialize(array(
			'charset' => $core->CONFIG['page_charset'],
			'result' => 1
		)));
	break;
	
	}
	
break;


//会员相关{
case 'User':
	
	switch($method){
	
	case 'synlogin':
		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
		
		list($winduid, $windid, $windpwd) = explode("\t", _strcode($params['user'], false));
		
		$member->login($windid, '', $winduid);
	break;
	
	case 'synlogout':
		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
		
		$member->logout();
	break;
	
	case 'deluser':
		
		$member->delete(array(
			'where' => $member->table .'.id IN ('. $param .')'
		), true);
		
	break;
	
	}
	
break;

//积分相关{
case 'Credit':

	switch($method){
	
	case 'get':
		$core->get_cache('credit');
		$credits = array();
		foreach($core->credits as $id => $v){
			$credits[$id] = $v['name'];
		}
		
		$return['result'] = $credits;
		
		exit(serialize($return));
	break;
	
	case 'syncredit':
		
	break;
	
	}

break;
//积分相关}
	
}
//会员相关}















//编/解码
function _strcode($string, $encode = true, $key = PW_APIKEY) {
	!$encode && $string = base64_decode($string);
	$code = '';
	$key  = substr(md5($_SERVER['HTTP_USER_AGENT'] . $key),8,18);
	$keylen = strlen($key);
	$strlen = strlen($string);
	for ($i = 0; $i < $strlen; $i++) {
		$k		= $i % $keylen;
		$code  .= $string[$i] ^ $key[$k];
	}
	return ($encode ? base64_encode($code) : $code);
}