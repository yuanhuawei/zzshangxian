<?php
/**
* 绑定模块的域名,仅用于核心模块
**/

$file = str_replace(array('\\', '\\\\'), '/', __FILE__);
$dir = dirname($file);

$module = basename($dir);
$system = 'core';

$_SERVER['_REQUEST_URI'] = substr(preg_replace('|^/.*index\.php|', '', $_SERVER['REQUEST_URI']), 1);
$_SERVER['_REQUEST_URI'] = '/index.php/'. $system .'/'. $module . $_SERVER['_REQUEST_URI'];

$_SERVER['SCRIPT_NAME'] = '/index.php';

require $dir .'/../../index.php';
?>