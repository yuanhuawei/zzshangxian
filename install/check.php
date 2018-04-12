<?php
$job=isset($_POST['job']) ? $_POST['job'] : '';

if($job=='db'){
	$host = isset($_POST['host']) ? $_POST['host'] : '';
	$port = isset($_POST['port']) ? $_POST['port'] : '';
	$user = isset($_POST['user']) ? $_POST['user'] : '';
	$pawd = isset($_POST['pawd']) ? $_POST['pawd'] : '';
	$name = isset($_POST['name']) ? $_POST['name'] : '';
	$charset = isset($_POST['charset']) ? $_POST['charset'] : '';

	$link = @mysql_connect($host.':'.$port, $user, $pawd) or exit('nolink');
	$version = mysql_get_server_info($link);
	$default_charset = '';
	if($version > '4.1'){
		//检查支不支持当前字符集
		mysql_query("SET NAMES $charset") or exit('charset');
		$default_charset = "DEFAULT CHARSET=$charset";
	}
	mysql_query("CREATE DATABASE IF NOT EXISTS `$name` $default_charset", $link) or exit('nocreate');
	mysql_select_db($name, $link) or exit('nodb');
	
	exit('true');	
}