<?php
defined('PHP168_PATH') or die();

/**
* ж��һ�����
**/

require_once PHP168_PATH .'install/install.func.php';

//ɾ������
$DB_master->delete(
	$core->TABLE_ .'config',
	"system = 'core' AND module LIKE '$this_plugin->name%'"
);

$DB_master->delete(
	$core->TABLE_ .'plugin',
	"name = '$this_plugin->name'"
);

if(is_file($this_plugin->path .'install/uninstall.php')){
	//ִ��ж�ؽű�
	require $this_plugin->path .'install/uninstall.php';
}

//ɾ������Ŀ¼
rm($this_plugin->path);
//ģ��Ŀ¼
rm(TEMPLATE_PATH .'plugin/'. $this_plugin->name);
//����
rm(CACHE_PATH .'core/plugin/'. $this_plugin->name);