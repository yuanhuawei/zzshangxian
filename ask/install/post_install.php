<?php
defined('PHP168_PATH') or die();

/**本系统个性风格**/
$this_system->set_config(array(
	'template' => S_version()? S_version() : 'media'
));

//添加一些初始化内容
$sql = get_install_sql(
	$DB_master,
	file_get_contents($this_system->path .'install/init_data.php'),
	$this_system->TABLE_
);
foreach($sql as $v){
	$DB_master->query($v);
}

$crontab = &$core->load_module('crontab');

//添加计划任务
$index_html_crontab_id = $crontab->add(array(
	'name' => to_installed_charset('问答首页定时静态'),
	'script' => $this_system->name .'_index_to_html.php',
	'day' => 0,
	'week' => 0,
	'month' => 0,
	'hour' => 3,
	'minute' => 0,
	'status' => 0
));

$this_system->set_config(array(
	'index_to_html_crontab_id' => $index_html_crontab_id
));