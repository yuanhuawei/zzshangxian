<?php
die();

class P8_Integrate_$type{

var $core;

function P8_Integrate_$type(&$core){
	$this->core = &$core;
	
}

/**
* 会员登录函数
* @param string $username 用户名
* @param string $password 密码
* @return array('status' => 登录状态, 'id' => 会员ID, 'message' => 信息) 
* 0 登录成功
* -1 用户名不存在
* -2 密码错误
**/
function login($username, $password){
	
	//uc_user_login($username, $password, $logintype, $checkques = 0, $question = '', $answer = '');
	return uc_user_login($username, md5($password), 0);
}

/**
* 会员退出
* 无参数
* @return 返回消息
**/
function logout(){
	return uc_user_synlogout();
}

/**
* 会员注册函数
* @param string $username 用户名
* @param string $password 密码
* @param string $email 邮箱
* @return int
* >0 返回的用户ID
* -1 用户名不合法
* -2 用户名己存在
* -3 email不合法
* -4 email被注册
**/
function register($username, $password, $email){
	$id = uc_user_register($username, $password, $email);
	
	return $id;
}

/**
* 检查邮箱合法性
* @param string $email 邮箱
* @return int 
* 0 合法
* -1 邮箱名非法
* -2 邮箱名己存在
**/
function check_email($email){
	$status = uc_data_request('user', 'checkEmail', $email);
	
	return $status == 1 ? 0 : $status;
}

/**
* @param string $username 用户名
* @return int 
* 0 合法
* -1 用户名非法
* -2 用户名己存在
**/
function check_username($username){
	$status = uc_data_request('user', 'checkName', $username);
	
	return $status == 1 ? 0 : $status;
}

/**
* @param string $ids 要删除的会员ID,以,分隔
* @return int 被删除的会员数
**/
function delete_member($ids){
	return uc_user_delete($uids);
}

/**
* 修改密码
* @param string $username 用户名
* @param string $password 密码
* @param string $old_password 旧密码
* 如果有旧密码的情况下不忽略旧密码, 必须旧密码正确才可以修改
* @param return int
* 0 修改成功
* -2 旧密码错误
**/
function passwd($username, $password, $old_password = ''){
	return uc_user_edit($uid, '', '', $password, '');
}

}