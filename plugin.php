<?php
$__FILE__ = __FILE__;
require_once dirname($__FILE__).'/inc/init.php';

/**
* 插件的入口, index.php/plugin.php/$plugin_name-$action
**/

//上次活动时间
$P8SESSION['lastview'] = P8_TIME;

//加载会员模块并验证
member_verify();

//加载全局语言包
load_language($core, 'global');

//获取URL路由
$router = $core->get_router();

if(empty($router)){
	P8_AJAX_REQUEST ? exit('{}') : message('access_denied');
}

if(count($action_router = match_action($router[0])) > 1){
	$plugin = $action_router[0];
	$ACTION = $action_router[1];
}else{
	$plugin = $router[0];
	$ACTION = 'index';
}

$ACTION = basename($ACTION);

if(in_array($ACTION, array('#', 'plugin'))){
	P8_AJAX_REQUEST ? exit('{}') : message('access_denied');
}

if(empty($core->plugins[$plugin]['enabled'])){
	P8_AJAX_REQUEST ? exit('{}') : message('no_such_plugin');
}


if(!is_file(PHP168_PATH .'plugin/'. $plugin .'/'. $ACTION .'.php')){
	P8_AJAX_REQUEST ? exit('{}') : message('access_denied');
}

//加载插件
$this_plugin = &$core->load_plugin($plugin);
if(empty($this_plugin)){
	P8_AJAX_REQUEST ? exit('{}') : message('no_such_plugin');
}

$this_router = $this_plugin->controller;

$this_url = $this_router .'-'. $ACTION;

$SKIN = $RESOURCE .'/skin/plugin/'. $plugin .'/';

//执行脚本
require $this_plugin->path . $ACTION .'.php';