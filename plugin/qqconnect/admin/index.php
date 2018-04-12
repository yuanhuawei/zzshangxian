<?php
defined('PHP168_PATH') or die();
if(REQUEST_METHOD == 'GET'){

	load_language($this_plugin, 'global');	//加载语言包
	$job = isset($_GET['job'])? $_GET['job'] : '';
	$config = $this_plugin->get_config(false);
	if(!$job){
		$config=$this_plugin->get_config();
		$config['display'] = !empty($config['display'])? $config['display']  : 6;
		$src=$this_plugin->url.'/icon';
		
		$role_module = $core->load_module('role');
		$role_module->groups || $role_module->get_group_cache();
		include $this_plugin->template('config');
		exit;
	}
	else if($job=='cache'){
		$this_plugin->_cache();
	}
	message('done',$this_url.'?plugin=qqconnect');
}elseif(REQUEST_METHOD == 'POST'){
$do=isset($_POST['do'])? $_POST['do']:'';
load_language($this_plugin, 'global');	//加载语言包
	if($do=='config'){
		$config = isset($_POST['config']) && is_array($_POST['config']) ? $_POST['config'] : array();
		
		$config['appid'] = $config['appid'];
		$config['appkey'] = $config['appkey'];
		$config['display'] = $config['display'];
		$config['role_gid'] = $config['role_gid'];
		$this_plugin->set_config($config);
		$this_plugin->_cache();
		message('done',$this_url.'?plugin=qqconnect',2);
	}
}