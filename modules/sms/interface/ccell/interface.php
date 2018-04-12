<?php
defined('PHP168_PATH') or die();

/**
* winic接口类,发送手机短信
*/

class P8_SMS_ccell{

var $send_method; //发送方式,GET或者POST
var $username;	  //用户名
var $password;	  //用户密码
var $api_url;

function __construct(&$sms, $config){
	
	$this->sms = &$sms;
	$this->send_method =  empty($config['send_method']) ? 'GET' : ($config['send_method'] == 'POST' ? 'POST' : 'GET');
	$this->username = empty($config['username']) ? '' : $config['username'];
	$this->password = empty($config['password']) ? '' : $config['password'];
	
	//$this->api_url = 'http://chineseserver.net:3388/CellServer/SmsAPI2/';
	
	//for test
	$this->api_url = 'http://211.147.244.114:9801/CASServer/SmsAPI/';
	
	require_once PHP168_PATH .'inc/xml.class.php';
}

function P8_SMS_ccell(&$sms, $config){
	$this->__construct($sms, $config);
}

function set($data){
	
}

/**
 * 发送短信到指定手机
 * =====================================================
 *-1.未知错误
 *1.服务器故障
 *2.账号不存在
 *3.密码不正确
 *4.无可用通道
 *5.号码错误
 *6.不能多线程访问
 *7.账号已冻结
 *8.短信内容不能为空
 *9.短信内容过长
 *10.发现非法字符
 *11.账户余额不足
 *12.号码过多
 *
 * ======================================================
 * @param $send_to {string} 收信人手机号
 * @param $message {string} 短信内容
 * @return {bool} true成功,false失败//根据上面的状态码返回发送是否成功
 */
function send($send_to, $message){
	global $P8LANG;
	$message = iconv('UTF-8', 'GB2312', $message);//将字符串的编码从UTF-8转到GB2312
	$rs = '';
	$status='-1';
	$retinfo='done';
	
	$param = 'userid='. $this->encode($this->username) .'&password='. $this->encode($this->password) .
		'&destnumbers='. $send_to .'&msg='. $this->encode($message);
	
	if($this->send_method == 'POST'){
		
		$rs = p8_http_request(array(
			'url' => $this->api_url .'SendMessage.jsp',
			'post' => $param
		));
	}else{
		
		$rs = p8_http_request(array('url' => $this->api_url .'SendMessage.jsp?'. $param));
	}
	
	$data = xml2array($rs['body']);
	
	if(empty($data['root'])) return false;
	
	$data = from_utf8($data);
	
	$root = &$data['root'];
	
	$retinfo = $root['attrs']['info'] .','. $P8LANG['send_number'] . $root['attrs']['numbers'] .','.
		$P8LANG['send_msg']. $root['attrs']['messages'];
	
	return $retinfo;
}

function encode($data){
	return urlencode(to_utf8($data));
}

function callback(){
	$param = 'userid='. $this->encode($this->username) .'&password='. $this->encode($this->password);
	
	if($this->send_method == 'POST'){
		p8_http_request(array('url' => $this->api_url .'ReceiveMessage.jsp', 'post' => $param));
	}else{
		$ret = p8_http_request(array('url' => $this->api_url .'ReceiveMessage.jsp?'. $param));
	}
	
	$data = xml2array($ret['body']);
	$data = from_utf8($data);
	
	write_file(CACHE_PATH .'log/ccell_callback.php', '<?php exit;?>'. date('Y-m-d H:i:s', P8_TIME) .' '. $this->api_url .'ReceiveMessage.jsp?'. $param ."\r\n". var_export($data, true) ."\r\n\r\n", 'a');
	
	if($data === null || empty($data['root']['children']['row'])) return null;
	
	foreach($data['root']['children']['row'] as $v){
		
		$this->sms->callback(
			$v['children']['sender'][0]['data'],
			$v['children']['msg'][0]['data'],
			$v['children']['mt'][0]['data']
		);
	}
}

}