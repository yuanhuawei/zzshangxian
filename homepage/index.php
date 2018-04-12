<?php

/**
* 绑定系统的域名
**/

$dir = dirname(__FILE__);
$path = basename($dir);

$_SERVER['_REQUEST_URI'] = preg_replace('|^/.*index\.php|', '', $_SERVER['REQUEST_URI']);
$_SERVER['_REQUEST_URI'] = '/homepage.php'. $_SERVER['_REQUEST_URI'];
$_SERVER['SCRIPT_NAME'] = '/homepage.php';

require $dir .'/../homepage.php';