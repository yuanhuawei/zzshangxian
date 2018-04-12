<?php
defined('PHP168_PATH') or die();

/**
* ²âÊÔMYSQLÁ¬½Ó
**/

$IS_ADMIN or exit();

if(REQUEST_METHOD == 'POST'){
	$host = isset($_POST['host']) ? $_POST['host'] : 'localhost';
	$port = isset($_POST['port']) ? $_POST['port'] : '3306';
	$user = isset($_POST['user']) ? $_POST['user'] : '';
	$db = isset($_POST['db']) ? $_POST['db'] : '';
	$charset = isset($_POST['charset']) ? $_POST['charset'] : '';
	$password = isset($_POST['password']) ? $_POST['password'] : '';
	$connect_type = isset($_POST['connect_type']) ? $_POST['connect_type'] : 'mysql';
	
	define('NO_ADMIN_LOG', true);

	$type = $connect = '';

	if(isset($core->CONFIG['mysql_connect_types'][$connect_type])){
		$type = $connect_type;
		require_once PHP168_PATH .'inc/'. $connect_type .'.class.php';
		
		$obj = new $core->CONFIG['mysql_connect_types'][$connect_type](
			$host,
			$user,
			$password,
			$db,
			$charset,
			$port,
			0
		);
		
		$connect = $obj->connect();
	}
	$obj->close();

	exit("{type:'$type',connect:'$connect'}");
}