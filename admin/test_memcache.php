<?php
defined('PHP168_PATH') or die();

/**
* ²âÊÔMEMCACHE
**/

$IS_ADMIN or exit();

if(REQUEST_METHOD == 'POST'){
	$available = class_exists('Memcache');
	
	define('NO_ADMIN_LOG', true);

	$available or die("0");

	$host = !empty($_POST['host']) ? $_POST['host'] : 'localhost';
	$port = !empty($_POST['port']) ? intval($_POST['port']) : 11211;

	$mem = new Memcache();
	$connect = @$mem->connect($host, $port);
	
	@$mem->close();
	
	exit($connect ? '1' : '0');
}
