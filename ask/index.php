<?php
/**
* ��ϵͳ������
**/

$dir = dirname(__FILE__);
$path = basename($dir);

$_SERVER['_REQUEST_URI'] = preg_replace('|^/.*index\.php|', '', $_SERVER['REQUEST_URI']);
$_SERVER['_REQUEST_URI'] = '/index.php/'. $path . $_SERVER['_REQUEST_URI'];
$_SERVER['SCRIPT_NAME'] = '/index.php';

require $dir .'/../index.php';
?>