<?php
defined('PHP168_PATH') or die();

$controller = &$core->controller($core);
$controller->check_admin_action('install_system') or message('no_privilege');

//加载安装时的语言包
load_language($this_system, 'install');

if(REQUEST_METHOD == 'GET'){
	
	
	
	//检查文件权限
	$file_perm = array(
		'template_dir_writable' => array(
			TEMPLATE_PATH .'default/'. $this_system->name .'/item/',
			is_writable(TEMPLATE_PATH .'default/'. $this_system->name .'/item/'),
			fileperm(TEMPLATE_PATH .'default/'. $this_system->name .'/item/')
		),
		
		'label_template_dir_writable' => array(
			TEMPLATE_PATH .'label/'. $this_system->name,
			is_writable(TEMPLATE_PATH .'label/'. $this_system->name),
			fileperm(TEMPLATE_PATH .'label/'. $this_system->name)
		),
		
		'language_dir_writable' => array(
			LANGUAGE_PATH .'zh-cn/'. $this_system->name .'/item/',
			is_writable(LANGUAGE_PATH .'zh-cn/'. $this_system->name .'/item/'),
			fileperm(LANGUAGE_PATH .'zh-cn/'. $this_system->name .'/item/')
		),
		
		'skin_dir_writable' => array(
			PHP168_PATH .'skin/default/'. $this_system->name .'/item/',
			is_writable(PHP168_PATH .'skin/default/'. $this_system->name .'/item/'),
			fileperm(PHP168_PATH .'skin/default/'. $this_system->name .'/item/')
		),
		
		'root_dir_writable' => array(
			$this_system->path,
			is_writable($this_system->path),
			fileperm($this_system->path)
		),
		
		'model_dir_writable' => array(
			$this_system->path .'model',
			is_writable($this_system->path .'model'),
			fileperm($this_system->path .'model')
		)
	);
	
	if(!empty($core->CONFIG['use_core_roles_only'])){
		$role = &$core->load_module('role');
		$role->get_cache();
		$roles = $role->get_by_system('core');
		
		$_roles = include $this_system->path .'install/roles.php';
	}
	
	include template($this_system, 'install', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$config = isset($_POST['config']) && is_array($_POST['config']) ? $_POST['config'] : array();
	
	$this_system->set_config($config);
	
	//开始安装文件
	require PHP168_PATH .'admin/install_system.php';
	
}