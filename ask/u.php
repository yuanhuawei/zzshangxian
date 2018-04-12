<?php
//绑定系统的域名
$dir = dirname(__FILE__);
$path = basename($dir);

$_SERVER['_REQUEST_URI'] = preg_replace('|^/.*u\.php|', '', $_SERVER['REQUEST_URI']);
$_SERVER['_REQUEST_URI'] = '/u.php/'. $path . $_SERVER['_REQUEST_URI'];
$_SERVER['SCRIPT_NAME'] = '/u.php';

require $dir .'/../u.php';
?>