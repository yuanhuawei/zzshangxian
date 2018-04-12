<?php
defined('PHP168_PATH') or die();

/**
* ϵͳ����
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){

	$config = $core->get_config('core', 'member');
	$info = include($this_module->path .'#.php');
	
	include template($this_module, 'integrate', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$config = isset($_POST['config']) && is_array($_POST['config']) ? $_POST['config'] : array();
	
	$this_module->set_config($config);
	
	if(!empty($config['integration_type'])){
		//��һ�����õ�����
		$core->set_config(array(
			'integration' => array(
				'type' => $config['integration_type'],
				'config' => $config[$config['integration_type']]
			)
		));
	}else{
		$core->set_config(array(
			'integration' => array(
				'type' => '',
				'config' => array()
			)
		));
	}
	
	message('done', HTTP_REFERER);
}