<?php
defined('PHP168_PATH') or die();

/**
* winic接口类,发送手机短信
*/

class P8_SMS_3068{

var $send_method; //发送方式,GET或者POST
var $username;	  //用户名
var $password;	  //用户密码
var $api_url;

function __construct(&$sms, $config){
	
	$this->sms = &$sms;
	$this->send_method =  empty($config['send_method']) ? 'GET' : ($config['send_method'] == 'POST' ? 'POST' : 'GET');
	$this->username = empty($config['username']) ? '' : $config['username'];
	$this->password = empty($config['password']) ? '' : $config['password'];
	$this->api_url = 'http://www.china-sms.com';
	
	require_once PHP168_PATH .'inc/xml.class.php';
}

function P8_SMS_3068(&$sms, $config){
	$this->__construct($sms, $config);
}

function set($data){
	
}

/**
 * 发送短信到指定手机
 * =====================================================
 *-6001 该企业用户无效
 
6002 此用户账号已经被停用  
6003 此用户密码错误 
6004 目标手机号码在保护名单内 
6005 发送内容中含非法字符
 
6006 发送通道不能对用户代收费 
6007 未找到合适通道给用户发短信 
6008 无效的手机号码 
6009 手机号码是黑名单 
6010 企业用户验证失败 
6011 企业不具备发送此号码的权限 
6012 该企业用户设置了ip限制 
6013 该企业用户余额不足 
6014 发送短信内容不能为空 
6015 短信内容超过了最大长度限制 
6016 企业密码必须大于4个字符 
6017 查询企业用户余额失败 
6018 用户没有开通SDK功能或测试已过期 
6019 此接口已经停止使用 
6020 此接口为vip客户专用接口 
6021 扩展号码未备案 

 *
 * ======================================================
 * @param $send_to {string} 收信人手机号
 * @param $message {string} 短信内容
 * @return {bool} true成功,false失败//根据上面的状态码返回发送是否成功
 */
function send($send_to, $message){
	global $P8LANG;
	
	$rs = '';
	$status='-1';
	$retinfo='done';
	$message = iconv('UTF-8', 'GB2312', $message);//将字符串的编码从UTF-8转到GB2312
	$message = urlencode($message );
	//$message = $st = preg_replace("/\s+/",'',$message);;
	$param = 'name='. $this->username .'&pwd='. $this->password .'&dst='. $send_to .'&msg='. $message;

	if($this->send_method == 'POST'){
		
		$rs = p8_http_request(array(
			'url' => $this->api_url .'/send/gsend.asp',
			'post' => $param
		));
	}else{
		
		$rs = p8_http_request(array('url' => $this->api_url .'/send/gsend.asp?'. $param));
		//$fp = fopen($this->api_url .'/send/gsend.asp?'. $param,"r");
		//$rs= fgetss($fp,255);
		//fclose($fp);
	}
	if($rs){
		$data = explode("&",$rs['body']);
		foreach($data as $detail){
			list($k,$v) = explode('=',$detail);
			$$k = $v;
		}
		$err = iconv('GB2312', 'UTF-8', $err);//将字符串的编码从GB2312转到UTF-8
		$retinfo = $P8LANG['send_number'] . $num .','.$P8LANG['send_msg']. $err;
	}

	return $retinfo;
}


function callback(){
	$param = 'name='. $this->username .'&pwd='. $this->password;
	
	if($this->send_method == 'POST'){
		p8_http_request(array('url' => $this->api_url .'send/readsms.asp', 'post' => $param));
	}else{
		$ret = p8_http_request(array('url' => $this->api_url .'send/readsms.asp?'. $param));
	}
	
	$data = explode('&',$data);
	write_file(CACHE_PATH .'log/ccell_callback.php', '<?php exit;?>'. date('Y-m-d H:i:s', P8_TIME) .' '. $this->api_url .'send/readsms.asp?'. $param ."\r\n". var_export($data, true) ."\r\n\r\n", 'a');
	
	if($data === null) return null;
	

		
		$this->sms->callback($data);
	
}

}