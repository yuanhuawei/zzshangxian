<?php
//��ģ�������,���ܰ󶨺���ģ��

$dir = dirname(__FILE__);
$path = basename($dir);

$system = 'core';
$module = basename($path);

$_SERVER['_REQUEST_URI'] = preg_replace('|^/.*u\.php/|', '', $_SERVER['REQUEST_URI']);
$_SERVER['_REQUEST_URI'] = '/u.php/'. $system .'/'. $module . $_SERVER['_REQUEST_URI'];
$_SERVER['SCRIPT_NAME'] = '/u.php';

require $dir .'/../../u.php';
?>