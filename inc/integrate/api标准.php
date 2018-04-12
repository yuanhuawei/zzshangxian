<?php
die();

class P8_Integrate_$type{

var $core;

function P8_Integrate_$type(&$core){
	$this->core = &$core;
	
}

/**
* ��Ա��¼����
* @param string $username �û���
* @param string $password ����
* @return array('status' => ��¼״̬, 'id' => ��ԱID, 'message' => ��Ϣ) 
* 0 ��¼�ɹ�
* -1 �û���������
* -2 �������
**/
function login($username, $password){
	
	//uc_user_login($username, $password, $logintype, $checkques = 0, $question = '', $answer = '');
	return uc_user_login($username, md5($password), 0);
}

/**
* ��Ա�˳�
* �޲���
* @return ������Ϣ
**/
function logout(){
	return uc_user_synlogout();
}

/**
* ��Աע�ắ��
* @param string $username �û���
* @param string $password ����
* @param string $email ����
* @return int
* >0 ���ص��û�ID
* -1 �û������Ϸ�
* -2 �û���������
* -3 email���Ϸ�
* -4 email��ע��
**/
function register($username, $password, $email){
	$id = uc_user_register($username, $password, $email);
	
	return $id;
}

/**
* �������Ϸ���
* @param string $email ����
* @return int 
* 0 �Ϸ�
* -1 �������Ƿ�
* -2 ������������
**/
function check_email($email){
	$status = uc_data_request('user', 'checkEmail', $email);
	
	return $status == 1 ? 0 : $status;
}

/**
* @param string $username �û���
* @return int 
* 0 �Ϸ�
* -1 �û����Ƿ�
* -2 �û���������
**/
function check_username($username){
	$status = uc_data_request('user', 'checkName', $username);
	
	return $status == 1 ? 0 : $status;
}

/**
* @param string $ids Ҫɾ���Ļ�ԱID,��,�ָ�
* @return int ��ɾ���Ļ�Ա��
**/
function delete_member($ids){
	return uc_user_delete($uids);
}

/**
* �޸�����
* @param string $username �û���
* @param string $password ����
* @param string $old_password ������
* ����о����������²����Ծ�����, �����������ȷ�ſ����޸�
* @param return int
* 0 �޸ĳɹ�
* -2 ���������
**/
function passwd($username, $password, $old_password = ''){
	return uc_user_edit($uid, '', '', $password, '');
}

}