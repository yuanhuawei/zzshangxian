<?php
define('UC_CLIENT_VERSION', '1.5.0');	//note UCenter �汾��ʶ
define('UC_CLIENT_RELEASE', '20081031');

define('API_DELETEUSER',			1);	//note �û�ɾ�� API �ӿڿ���
define('API_RENAMEUSER',			1);	//note �û����� API �ӿڿ���
define('API_GETTAG',				1);	//note ��ȡ��ǩ API �ӿڿ���
define('API_SYNLOGIN',				1);	//note ͬ����¼ API �ӿڿ���
define('API_SYNLOGOUT',				1);	//note ͬ���ǳ� API �ӿڿ���
define('API_UPDATEPW',				1);	//note �����û����� ����
define('API_UPDATEBADWORDS',		1);	//note ���¹ؼ����б� ����
define('API_UPDATEHOSTS',			1);	//note ���������������� ����
define('API_UPDATEAPPS',			1);	//note ����Ӧ���б� ����
define('API_UPDATECLIENT',			1);	//note ���¿ͻ��˻��� ����
define('API_UPDATECREDIT',			1);	//note �����û����� ����
define('API_GETCREDITSETTINGS',		1);	//note �� UCenter �ṩ�������� ����
define('API_GETCREDIT',				1);	//note ��ȡ�û���ĳ����� ����
define('API_UPDATECREDITSETTINGS',	1);	//note ����Ӧ�û������� ����

define('API_RETURN_SUCCEED',		'1');
define('API_RETURN_FAILED',			'-1');
define('API_RETURN_FORBIDDEN',		'-2');

require dirname(__FILE__) .'/../inc/init.php';

$member = &$core->load_module('member');

if(empty($member->CONFIG['uc'])){
	//���û������UC
	exit(API_RETURN_FORBIDDEN);
}

$uc_config = &$member->CONFIG['uc'];

define('UC_KEY', $uc_config['key']);// �� UCenter ��ͨ����Կ, Ҫ�� UCenter ����һ��


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

























//����UC ֪ͨ
switch($get['action']){
/* ����{ */
case 'test':
	exit(API_RETURN_SUCCEED);
break;
/* ����} */

/* ͬ����¼{ */
case 'synlogin':
	API_SYNLOGIN or exit(API_RETURN_FORBIDDEN);
	
	header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
	
	$member->login($get['username'], '', $get['uid']);
break;
/* ͬ����¼} */

/* ͬ���˳�{ */
case 'synlogout':
	API_SYNLOGOUT or exit(API_RETURN_FORBIDDEN);
	
	header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
	
	$member->logout(true);
break;
/* ͬ���˳�} */

/* �޸�����{ */
case 'updatepw':
	API_UPDATEPW or exit(API_RETURN_FORBIDDEN);
	
	//if(!empty($member->CONFIG['administrators'][$get['username']]))
	$member->change_password($get['username'], $get['password'], '', true);
	
	exit(API_RETURN_SUCCEED);
break;
/* �޸�����} */

/* ɾ���û�{ */
case 'deleteuser':
	API_DELETEUSER or exit(API_RETURN_FORBIDDEN);
	
	$member->delete(array(
		'where' => $member->table .'.id IN ('. $get['ids'] .')'
	), true);
	
	exit(API_RETURN_SUCCEED);
break;
/* ɾ���û�} */

/* ���ݻ��ָ�UC{ */
case 'getcreditsettings':
	API_GETCREDITSETTINGS or exit(API_RETURN_FORBIDDEN);
	
	$core->integrate();
	
	$ret = array();
	foreach($core->credits as $id => $v){
		$ret[$id] = array($v['name'], $v['unit']);
	}
	exit(uc_serialize($ret));
break;
/* ���ݻ��ָ�UC} */

/* ���»���{ */
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
/* ���»���} */

/* Ӧ��{ */
case 'updateapps':
	API_UPDATEAPPS or exit(API_RETURN_FORBIDDEN);
	
	exit(API_RETURN_SUCCEED);
break;
/* Ӧ�� }*/

/* ��ȡ�û�����{ */
case 'getcredit':
	API_UPDATECREDIT or exit(API_RETURN_FORBIDDEN);
	
	$uid = intval($get['uid']);
	$credit = intval($get['credit']);
	
	$credits = $core->get_credit($uid);
	echo isset($credits[$credit]) ? $credits[$credit] : '';
	exit;

break;
/* ��ȡ�û�����} */

}
































//UC��غ���
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
