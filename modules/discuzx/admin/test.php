<?php
defined('PHP168_PATH') or die();

/**
* ÅäÖÃ
**/

$this_controller->check_admin_action('config') or message('no_privilege');

define('NO_ADMIN_LOG', true);

if(REQUEST_METHOD == 'POST'){
	
	$config = isset($_POST['config']) && is_array($_POST['config']) ? $_POST['config'] : array();
	
	$_db = new P8_Mysql(
		isset($config['db']['host']) ? $config['db']['host'] : '',
		isset($config['db']['user']) ? $config['db']['user'] : '',
		isset($config['db']['password']) ? $config['db']['password'] : '',
		isset($config['db']['name']) ? $config['db']['name'] : '',
		isset($config['db']['charset']) ? $config['db']['charset'] : '',
		isset($config['db']['port']) ? $config['db']['port'] : ''
	);
	
	$pre = isset($config['db']['table_prefix']) ? $config['db']['table_prefix'] : '';
	
	exit((string)count($_db->fetch_all("SELECT * FROM {$pre}common_member LIMIT 1")));
}