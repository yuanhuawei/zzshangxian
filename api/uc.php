<?php
define('UC_CLIENT_VERSION', '1.5.0');	//note UCenter 版本标识
define('UC_CLIENT_RELEASE', '20081031');

define('API_DELETEUSER',			1);	//note 用户删除 API 接口开关
define('API_RENAMEUSER',			1);	//note 用户改名 API 接口开关
define('API_GETTAG',				1);	//note 获取标签 API 接口开关
define('API_SYNLOGIN',				1);	//note 同步登录 API 接口开关
define('API_SYNLOGOUT',				1);	//note 同步登出 API 接口开关
define('API_UPDATEPW',				1);	//note 更改用户密码 开关
define('API_UPDATEBADWORDS',		1);	//note 更新关键字列表 开关
define('API_UPDATEHOSTS',			1);	//note 更新域名解析缓存 开关
define('API_UPDATEAPPS',			1);	//note 更新应用列表 开关
define('API_UPDATECLIENT',			1);	//note 更新客户端缓存 开关
define('API_UPDATECREDIT',			1);	//note 更新用户积分 开关
define('API_GETCREDITSETTINGS',		1);	//note 向 UCenter 提供积分设置 开关
define('API_GETCREDIT',				1);	//note 获取用户的某项积分 开关
define('API_UPDATECREDITSETTINGS',	1);	//note 更新应用积分设置 开关

define('API_RETURN_SUCCEED',		'1');
define('API_RETURN_FAILED',			'-1');
define('API_RETURN_FORBIDDEN',		'-2');

require dirname(__FILE__) .'/../inc/init.php';

$member = &$core->load_module('member');

if(empty($member->CONFIG['uc'])){
	//如果没有设置UC
	exit(API_RETURN_FORBIDDEN);
}

$uc_config = &$member->CONFIG['uc'];

define('UC_KEY', $uc_config['key']);// 与 UCenter 的通信密钥, 要与 UCenter 保持一致


$get = $post = array();

$code = @$_GET['code'];
parse_str(_authcode($code, 'DECODE', UC_KEY), $get);

if(empty($get)) {
	exit('Invalid Request');
}

$get = p8_stripslashes2($get);

if(P8_TIME - $get['time'] > 3600) {
	exit('Authracation has expiried');
}
if(empty($get)) {
	exit('Invalid Request');
}

























//接收UC 通知
switch($get['action']){
/* 测试{ */
case 'test':
	exit(API_RETURN_SUCCEED);
break;
/* 测试} */

/* 同步登录{ */
case 'synlogin':
	API_SYNLOGIN or exit(API_RETURN_FORBIDDEN);
	
	header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
	
	$member->login($get['username'], '', $get['uid']);
break;
/* 同步登录} */

/* 同步退出{ */
case 'synlogout':
	API_SYNLOGOUT or exit(API_RETURN_FORBIDDEN);
	
	header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
	
	$member->logout(true);
break;
/* 同步退出} */

/* 修改密码{ */
case 'updatepw':
	API_UPDATEPW or exit(API_RETURN_FORBIDDEN);
	
	//if(!empty($member->CONFIG['administrators'][$get['username']]))
	$member->change_password($get['username'], $get['password'], '', true);
	
	exit(API_RETURN_SUCCEED);
break;
/* 修改密码} */

/* 删除用户{ */
case 'deleteuser':
	API_DELETEUSER or exit(API_RETURN_FORBIDDEN);
	
	$member->delete(array(
		'where' => $member->table .'.id IN ('. $get['ids'] .')'
	), true);
	
	exit(API_RETURN_SUCCEED);
break;
/* 删除用户} */

/* 传递积分给UC{ */
case 'getcreditsettings':
	API_GETCREDITSETTINGS or exit(API_RETURN_FORBIDDEN);
	
	$core->integrate();
	
	$ret = array();
	foreach($core->credits as $id => $v){
		$ret[$id] = array($v['name'], $v['unit']);
	}
	exit(uc_serialize($ret));
break;
/* 传递积分给UC} */

/* 更新积分{ */
case 'updatecredit':
	API_UPDATECREDIT or exit(API_RETURN_FORBIDDEN);
	
	$credit = intval($get['credit']);
	$amount = intval($get['amount']);
	$uid = intval($get['uid']);
	
	$core->update_credit(
		$uid,
		array($credit => $amount)
	);
	
	exit(API_RETURN_SUCCEED);
break;
/* 更新积分} */

/* 应用{ */
case 'updateapps':
	API_UPDATEAPPS or exit(API_RETURN_FORBIDDEN);
	
	exit(API_RETURN_SUCCEED);
break;
/* 应用 }*/

/* 获取用户积分{ */
case 'getcredit':
	API_UPDATECREDIT or exit(API_RETURN_FORBIDDEN);
	
	$uid = intval($get['uid']);
	$credit = intval($get['credit']);
	
	$credits = $core->get_credit($uid);
	echo isset($credits[$credit]) ? $credits[$credit] : '';
	exit;

break;
/* 获取用户积分} */

}
































//UC相关函数
if(!function_exists('xml_serialize')) {
	include_once PHP168_PATH .'inc/integrate/uc/lib/xml.class.php';
}


function _authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	$ckey_length = 4;

	$key = md5($key ? $key : UC_KEY);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);

	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);

	$result = '';
	$box = range(0, 255);

	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}

	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}

	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}

	if($operation == 'DECODE') {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
				return '';
			}
	} else {
		return $keyc.str_replace('=', '', base64_encode($result));
	}

}
