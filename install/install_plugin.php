<?php
defined('PHP168_PATH') or die();

/**
* 安装一个插件
**/

require_once PHP168_PATH .'install/install.func.php';
load_language($this_plugin, 'global');
$DB_master->update(
	$core->TABLE_ .'plugin',
	array(
		'installed' => 1,
		'enabled' => 1
	),
	"name = '$this_plugin->name'"
);

$core->plugins[$this_plugin->name]['installed'] = true;

if(is_file($this_plugin->path .'install/sql.php')){
	$sql = get_install_sql(
		$DB_master,
		file_get_contents($this_plugin->path .'install/sql.php'),
		$this_plugin->TABLE_,
		true
	);
	
	foreach($sql as $v){
		$DB_master->query($v);
	}
}


//自定义完成安装操作
if(is_file($this_plugin->path .'install/install.php'))
	include $this_plugin->path .'install/install.php';