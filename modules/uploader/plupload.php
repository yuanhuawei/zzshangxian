<?php
/**
* SWF上传的中转文件,主要把SESSION ID传给另一个脚本, 只接受POST请求
**/
if(strtoupper($_SERVER['REQUEST_METHOD']) != 'POST' || !isset($_POST['SESSION_ID']) || !isset($_POST['user_agent'])) exit("error");

$path = dirname(__FILE__);
$config = @include $path .'/../../data/core/core.php';

if(empty($config['cookie'])){
	exit("error");
}

$_COOKIE[$config['cookie']['prefix'] .'P8SESSION'] = $_POST['SESSION_ID'];
$_SERVER['HTTP_USER_AGENT'] = $_POST['user_agent'];

//修改路由
$_SERVER['_REQUEST_URI'] = '/index.php/core/uploader-rplupload';
require $path .'/../../index.php';