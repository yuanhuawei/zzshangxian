<?php
defined('PHP168_PATH') or die();

/**
* 测试UC连通情况
**/

$IS_ADMIN or exit('0');

if(REQUEST_METHOD == 'POST'){
	
	define('NO_ADMIN_LOG', true);
	
	$config = array(
		'connect' => isset($_POST['connect']) ? $_POST['connect'] : '',
		'db_host' => isset($_POST['db_host']) ? $_POST['db_host'] : '',
		'db_user' => isset($_POST['db_user']) ? $_POST['db_user'] : '',
		'db_password' => isset($_POST['db_password']) ? $_POST['db_password'] : '',
		'db_name' => isset($_POST['db_name']) ? $_POST['db_name'] : '',
		'db_charset' => isset($_POST['db_charset']) ? $_POST['db_charset'] : '',
		'db_table_prefix' => isset($_POST['db_table_prefix']) ? $_POST['db_table_prefix'] : '',
		'key' => isset($_POST['key']) ? $_POST['key'] : '',
		'api' => isset($_POST['api']) ? $_POST['api'] : '',
		'ip' => isset($_POST['ip']) ? $_POST['ip'] : '',
		'charset' => isset($_POST['charset']) ? $_POST['charset'] : '',
		'appid' => isset($_POST['appid']) ? $_POST['appid'] : ''
	);
	
	$core->CONFIG['integration']['type'] = 'uc';
	$core->CONFIG['integration']['config'] = $config;
	
	$core->integrate();
	
	uc_app_ls() or exit('0');
	
	exit('1');
}