<?php
/**
* �����ϴ���JSON��ʽ,���Կ���, ֻ������İ�ͬһ������
* [{id: �ļ�ID, file: �ļ�·��, name: �ļ�����}, ...]
**/
//header('Content-type: text/javascript; charset=utf-8');
header('Pragma: no-cache');
header('Cache-Control: no-cache, must-revalidate');

isset($_COOKIE['p8_upload_json']) or exit('\'\'');

$config = @include dirname(__FILE__) .'/../data/core/core.php';
if(empty($config)) exit('');

$cookie = $_COOKIE['p8_upload_json'];

$jsonp = get_magic_quotes_gpc() ? stripslashes($cookie) : $cookie;

setcookie('p8_upload_json', '', -1, '/', $config['base_domain']);

//��JS���õ�COOKIE����escape,��UTF-8,������%u��ͷ,ת��\u�Ϳ���
echo isset($_GET['callback']) ? $_GET['callback'] .'('. str_replace('%u', '\\u', $jsonp) .');' : '';
exit;