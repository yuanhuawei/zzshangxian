<?php
/**
* SWF�ϴ�����ת�ļ�,��Ҫ��SESSION ID������һ���ű�, ֻ����POST����
**/
if(strtoupper($_SERVER['REQUEST_METHOD']) != 'POST' || !isset($_POST['SESSION_ID']) || !isset($_POST['user_agent'])) exit("error");

$path = dirname(__FILE__);
$config = @include $path .'/../../data/core/core.php';

if(empty($config['cookie'])){
	exit("error");
}

$_COOKIE[$config['cookie']['prefix'] .'P8SESSION'] = $_POST['SESSION_ID'];
$_SERVER['HTTP_USER_AGENT'] = $_POST['user_agent'];

//�޸�·��
$_SERVER['_REQUEST_URI'] = '/index.php/core/uploader-rplupload';
require $path .'/../../index.php';