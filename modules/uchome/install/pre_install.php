<?php
defined('PHP168_PATH') or die();

$this_module->set_config(array(
	'db' => array(
		'host' => 'localhost',
		'user' => 'user',
		'password' => '',
		'port' => '3306',
		'name' => 'uchome',
		'charset' => $DB_master->charset,
		'table_prefix' => 'uchome_',
	),
	
	'url' => 'http://www.xxx.com',
	'charset' => $core->CONFIG['page_charset']
));
