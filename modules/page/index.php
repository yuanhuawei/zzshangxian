<?php
//系统名称
$path = basename(dirname(__FILE__));

//$shadow_domain = basename($_SERVER['SERVER_NAME'], '.168news.com');	//URL上的

//if($shadow_domain == 'www'){
	$_SERVER['_REQUEST_URI'] = preg_replace('|^/.*index\.php|', '', $_SERVER['REQUEST_URI']);
	$_SERVER['_REQUEST_URI'] = '/index.php/'. $path . $_SERVER['_REQUEST_URI'];
	$_SERVER['SCRIPT_NAME'] = '/index.php';
//}

require dirname(__FILE__) .'/../index.php';
?>