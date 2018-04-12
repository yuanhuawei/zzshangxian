<?php
defined('PHP168_PATH') or die();

/**
* winic�ӿ���,�����ֻ�����
*/

class P8_SMS_panzer{

var $send_method; //���ͷ�ʽ,GET����POST
var $username;	  //�û���
var $password;	  //�û�����
var $orgid;			//��������
var $connkey;		//�ӿ���֤��

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
 * ���Ͷ��ŵ�ָ���ֻ�
 * =====================================================
 *0.�ɹ�
 *100.��ʱ�ɹ�
 *-1.����ʧ��
 *-2.�ʺŴ���
 *-3.�������
 *-4.��������
 *-5.���ݲ��Ϸ�
 *-6.���벻�Ϸ�
 *-7.�û�����ʱ����
 *-8.����
 *-9.��·�쳣
 *-10.�ǽӿ��û�
 *-11.��֤key����
 *-12.SP���ͳ�ʱ
 *-15.�ʺű���ֹ
 *-20.�޿��õ�ͨ��
 *-30.�������Ŵ���
 *-31.�����а����ܾ����͵ĺ���
 *-100.�Ƿ�����
 *
 * ======================================================
 * @param $send_to {string} �������ֻ���
 * @param $message {string} ��������
 * @return {bool} true�ɹ�,falseʧ��//���������״̬�뷵�ط����Ƿ�ɹ�
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
