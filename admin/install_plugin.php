<?php
defined('PHP168_PATH') or die();

/**
* 安装一个插件
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'POST'){
	
	$plugin = isset($_POST['plugin']) ? $_POST['plugin'] : '';
	
	$this_plugin = &$core->load_plugin($plugin);
	
	include PHP168_PATH .'install/install_plugin.php';
	
	require_once PHP168_PATH .'inc/cache.func.php';

	//更新缓存
	cache_system_module();
	
	message('done', HTTP_REFERER, 1);

}