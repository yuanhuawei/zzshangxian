<?php
defined('PHP168_PATH') or die();

/**
* �޸ĺ�������
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	load_language($core, 'config');

	$config = $core->get_config('core', '');
	$info = include $core->path .'#.php';
	$config = array_merge($info, $core->CONFIG, $config);
	
	include template($core, 'config', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$_POST = p8_stripslashes2($_POST);
	
	$config = isset($_POST['config']) ? (array)$_POST['config'] : array();
	
	$orig_admin_controller = $core->CONFIG['admin_controller'];
	
	$core->set_config($config);
	
	//������޸ĺ�̨���
	if(!empty($config['admin_controller']) && $config['admin_controller'] != $orig_admin_controller){
		$config['admin_controller'] = basename($config['admin_controller']);
		
		//����һ����̨����ļ�,���ºû���֮�����ɾ��ԭ����̨����ļ�
		is_file(PHP168_PATH . $config['admin_controller']) or copy(PHP168_PATH . $orig_admin_controller, PHP168_PATH . $config['admin_controller']);
		
		//���Ҹ��²˵�����
		require PHP168_PATH .'inc/cache.func.php';
		
		cache_admin_menu();
		unlink(PHP168_PATH . $orig_admin_controller);
	}
	
	message('done');
}