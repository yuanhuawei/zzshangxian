<?php
$__FILE__ = __FILE__;
require_once dirname($__FILE__).'/inc/init.php';

/**
* ��������, index.php/plugin.php/$plugin_name-$action
**/

//�ϴλʱ��
$P8SESSION['lastview'] = P8_TIME;

//���ػ�Աģ�鲢��֤
member_verify();

//����ȫ�����԰�
load_language($core, 'global');

//��ȡURL·��
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

//���ز��
$this_plugin = &$core->load_plugin($plugin);
if(empty($this_plugin)){
	P8_AJAX_REQUEST ? exit('{}') : message('no_such_plugin');
}

$this_router = $this_plugin->controller;

$this_url = $this_router .'-'. $ACTION;

$SKIN = $RESOURCE .'/skin/plugin/'. $plugin .'/';

//ִ�нű�
require $this_plugin->path . $ACTION .'.php';