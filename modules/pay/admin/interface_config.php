<?php
defined('PHP168_PATH') or die();

/**
* ֧���ӿ�����
**/

$this_controller->check_admin_action('interface') or message('no_privilege');

//���֧���ӿ��Ƿ����
$interface = isset($_REQUEST['name']) ? basename($_REQUEST['name']) : '';
isset($this_module->CONFIG['interfaces'][$interface]) or message('no_such_pay_interface');

//�������԰�
load_language($this_module, 'interface/'. $interface);

if(REQUEST_METHOD == 'GET'){
	
	//��ȡ����
	$config = $this_module->interface_config($interface);
	
	include template($this_module, 'interface_config/'. $interface, 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$_POST = p8_stripslashes2($_POST);
	
	$config = isset($_POST['config']) ? (array) $_POST['config'] : array();
	
	//д������
	$this_module->interface_config($interface, 0, $config) or message('fail');
	
	message('done');
	
}