<?php
defined('PHP168_PATH') or die();

class P8_Integrate_uc{

var $core;

function __construct(&$core){
	$this->core = &$core;
	
	!empty($core->CONFIG['integration']['config']) or die('UC!');
	
	$uc_config = &$core->CONFIG['integration']['config'];

	define('UC_CONNECT', $uc_config['connect']);			// 连接 UCenter 的方式: mysql/NULL, 默认为空时为 fscoketopen()
	// mysql 是直接连接的数据库, 为了效率, 建议采用 mysql

	//数据库相关 (mysql 连接时, 并且没有设置 UC_DBLINK 时, 需要配置以下变量)
	define('UC_DBHOST',		$uc_config['db_host']);			// UCenter 数据库主机
	define('UC_DBUSER',		$uc_config['db_user']);			// UCenter 数据库用户名
	define('UC_DBPW',		$uc_config['db_password']);		// UCenter 数据库密码
	define('UC_DBNAME',		$uc_config['db_name']);			// UCenter 数据库名称
	define('UC_DBCHARSET',	$uc_config['db_charset']);		// UCenter 数据库字符集
	define('UC_DBTABLEPRE',	$uc_config['db_table_prefix']);	// UCenter 数据库表前缀

	//通信相关
	defined('UC_KEY') or define('UC_KEY',		$uc_config['key']);		// 与 UCenter 的通信密钥, 要与 UCenter 保持一致
	define('UC_API',		$uc_config['api']);		// UCenter 的 URL 地址, 在调用头像时依赖此常量
	define('UC_CHARSET',	$uc_config['charset']);	// UCenter 的字符集
	define('UC_IP',			$uc_config['ip']);		// UCenter 的 IP, 当 UC_CONNECT 为非 mysql 方式时, 并且当前应用服务器解析域名有问题时, 请设置此值
	define('UC_APPID',		$uc_config['appid']);	// 当前应用的 ID
	
	require PHP168_PATH .'inc/integrate/uc/client.php';
}

function P8_Integrate_uc(&$core){
	$this->__construct($core);
}

function login($username, $password){
	list($uid, $username, $password, $email) = uc_user_login($_POST['username'], $_POST['password']);
	
	return array(
		'id' => $uid,
		'username' => $username,
		'password' => $password,
		'email' => $email,
		'message' => uc_user_synlogin($uid)
	);
}

function logout(){
	return uc_user_synlogout();
}

function register($username, $password, $email){
	
	switch($status = uc_user_register($username, $password, $email)){
		case -3:
			//用户己存在
			return -2;
		break;
		
		case -1: 
		case -2: 
			return -1;//用户名不合法
		break;
		
		case -4:	//email不合法
		case -5:	//email不允许
			return -3;
		break;
		
		case -6:	//email被注册
			return -4;
	}
	
	return $status;
}

function check_username($username){
	switch(uc_user_checkname($username)){
		case -1:
		case -2:
			return -1;
		break;
		
		case -3:
			return -2;
		break;
		
		default:
			return 0;
	}
}

function check_email($email){
	switch(uc_user_checkemail($email)){
		case -4:
		case -5:
			return -1;
		break;
		
		case -6:
			return -2;
		break;
		
		default:
			return 0;
	}
}

function delete_member($ids){
	return uc_user_delete($ids);
}

function passwd($username, $password, $old_password = ''){
	switch(uc_user_edit($username, $old_password, $password, '', strlen($old_password) ? 0 : 1)){
		case -1:
			//旧密码错误
			return -2;
		break;
		
		case 1:
			//修改成功
			return 0;
		break;
		
		case -8:
			//受保护的用户,要传入旧密码才可以修改
		break;
	}
}


function pm_checknew($uid, $more = 0) {
	$return = call_user_func(UC_API_FUNC, 'pm', 'check_newpm', array('uid'=>$uid, 'more'=>$more));
	return (!$more || UC_CONNECT == 'mysql') ? $return : uc_unserialize($return);
}

function pm_send($fromuid, $msgto, $subject, $message, $instantly = 1, $replypmid = 0, $isusername = 0) {
	if($instantly) {
		$replypmid = @is_numeric($replypmid) ? $replypmid : 0;
		return call_user_func(UC_API_FUNC, 'pm', 'sendpm', array('fromuid'=>$fromuid, 'msgto'=>$msgto, 'subject'=>$subject, 'message'=>$message, 'replypmid'=>$replypmid, 'isusername'=>$isusername));
	} else {
		$fromuid = intval($fromuid);
		$subject = urlencode($subject);
		$msgto = urlencode($msgto);
		$message = urlencode($message);
		$replypmid = @is_numeric($replypmid) ? $replypmid : 0;
		$replyadd = $replypmid ? "&pmid=$replypmid&do=reply" : '';
		$apiurl = uc_api_url('pm_client', 'send', "uid=$fromuid", "&msgto=$msgto&subject=$subject&message=$message$replyadd");
		@header("Expires: 0");
		@header("Cache-Control: private, post-check=0, pre-check=0, max-age=0", FALSE);
		@header("Pragma: no-cache");
		@header("location: ".$apiurl);
	}
}


function pm_delete($uid, $folder, $pmids) {
	return call_user_func(UC_API_FUNC, 'pm', 'delete', array('uid'=>$uid, 'folder'=>$folder, 'pmids'=>$pmids));
}

function pm_deleteuser($uid, $touids) {
	return call_user_func(UC_API_FUNC, 'pm', 'deleteuser', array('uid'=>$uid, 'touids'=>$touids));
}

function pm_readstatus($uid, $uids, $pmids = array(), $status = 0) {
	return call_user_func(UC_API_FUNC, 'pm', 'readstatus', array('uid'=>$uid, 'uids'=>$uids, 'pmids'=>$pmids, 'status'=>$status));
}

function pm_list($uid, $page = 1, $pagesize = 10, $folder = 'inbox', $filter = 'newpm', $msglen = 0) {
	$uid = intval($uid);
	$page = intval($page);
	$pagesize = intval($pagesize);
	$return = call_user_func(UC_API_FUNC, 'pm', 'ls', array('uid'=>$uid, 'page'=>$page, 'pagesize'=>$pagesize, 'folder'=>$folder, 'filter'=>$filter, 'msglen'=>$msglen));
	return UC_CONNECT == 'mysql' ? $return : uc_unserialize($return);
}

function pm_ignore($uid) {
	$uid = intval($uid);
	return call_user_func(UC_API_FUNC, 'pm', 'ignore', array('uid'=>$uid));
}

function pm_view($uid, $pmid, $touid = 0, $daterange = 1) {
	$uid = intval($uid);
	$touid = intval($touid);
	$pmid = @is_numeric($pmid) ? $pmid : 0;
	$return = call_user_func(UC_API_FUNC, 'pm', 'view', array('uid'=>$uid, 'pmid'=>$pmid, 'touid'=>$touid, 'daterange'=>$daterange));
	return UC_CONNECT == 'mysql' ? $return : uc_unserialize($return);
}

function pm_viewnode($uid, $type = 0, $pmid = 0) {
	$uid = intval($uid);
	$pmid = @is_numeric($pmid) ? $pmid : 0;
	$return = call_user_func(UC_API_FUNC, 'pm', 'viewnode', array('uid'=>$uid, 'pmid'=>$pmid, 'type'=>$type));
	return UC_CONNECT == 'mysql' ? $return : uc_unserialize($return);
}

function pm_blackls_get($uid) {
	$uid = intval($uid);
	return call_user_func(UC_API_FUNC, 'pm', 'blackls_get', array('uid'=>$uid));
}

function pm_blackls_set($uid, $blackls) {
	$uid = intval($uid);
	return call_user_func(UC_API_FUNC, 'pm', 'blackls_set', array('uid'=>$uid, 'blackls'=>$blackls));
}

function pm_blackls_add($uid, $username) {
	$uid = intval($uid);
	return call_user_func(UC_API_FUNC, 'pm', 'blackls_add', array('uid'=>$uid, 'username'=>$username));
}

function pm_blackls_delete($uid, $username) {
	$uid = intval($uid);
	return call_user_func(UC_API_FUNC, 'pm', 'blackls_delete', array('uid'=>$uid, 'username'=>$username));
}

}