<?php
defined('PHP168_PATH') or die();

/**
* winic接口类,发送手机短信
*/

class P8_SMS_panzer{

var $send_method; //发送方式,GET或者POST
var $username;	  //用户名
var $password;	  //用户密码
var $orgid;			//机构代码
var $connkey;		//接口验证码

function __construct(&$sms, $config){
	$this->sms = &$sms;
	
	$this->send_method = empty($config['send_method']) ? 'POST' : ($config['send_method'] == 'GET' ? 'GET' : 'POST');
	$this->username = empty($config['username']) ? '' : $config['username'];
	$this->password = empty($config['password']) ? '' : $config['password'];
	$this->orgid = empty($config['orgid']) ? '' : $config['orgid'];
	$this->connkey = empty($config['connkey']) ? '' : $config['connkey'];
}

function P8_SMS_panzer(&$sms, $config){
	$this->__construct($sms, $config);
}

/**
 * 发送短信到指定手机
 * =====================================================
 *0.成功
 *100.定时成功
 *-1.发送失败
 *-2.帐号错误
 *-3.密码错误
 *-4.机构错误
 *-5.内容不合法
 *-6.号码不合法
 *-7.用户被临时禁用
 *-8.余额不足
 *-9.网路异常
 *-10.非接口用户
 *-11.认证key错误
 *-12.SP发送超时
 *-15.帐号被禁止
 *-20.无可用的通道
 *-30.更新批号错误
 *-31.号码中包含拒绝发送的号码
 *-100.非法调用
 *
 * ======================================================
 * @param $send_to {string} 收信人手机号
 * @param $message {string} 短信内容
 * @return {bool} true成功,false失败//根据上面的状态码返回发送是否成功
 */
function send($send_to,$message){
	global $P8LANG,$core;
	$url = '';
	$rs = '';
	$status='0';
	$retinfo='done';
	$p8time = date("Y-m-d H:i:s");
	$send_to=str_replace(array(' ',',','|','/','\\'),";",$send_to);
	if($core->CONFIG['page_charset'] == 'utf-8'){
		$message=mb_convert_encoding($message,'gbk','utf-8');;
	}
	if($this->send_method=='POST'){
		$url = 'http://59.42.247.51/http.php';
		$post_data = "act=send&orgid=$this->orgid&connkey=$this->connkey&username=$this->username&passwd=$this->password&sendTime=$p8time&destnumbers=$send_to&msg=". urlencode($message);
		
		$rs = p8_http_request(array(
			'url' => $url,
			'post' => $post_data
		));
	}else{
		$url = "http://59.42.247.51/http.php?act=send&orgid=$this->orgid&connkey=$this->connkey&username=$this->username&passwd=$this->password&sendTime=$p8time&destnumbers=$send_to&msg=". urlencode($message);
		
		$rs = p8_http_request(array('url' => $url));
	}
	if($rs){
		preg_match("/^state=(\-?[\d]{1,3})/",$rs['body'],$state);
		$status=$state['1'];
		$retinfo=$P8LANG[$status];
	}
	echo $post_data;
	return $retinfo;
}

}
