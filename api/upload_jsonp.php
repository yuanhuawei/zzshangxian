<?php
/**
* 返回上传的JSON格式,可以跨域, 只能与核心绑定同一个域名
* [{id: 文件ID, file: 文件路径, name: 文件名称}, ...]
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

//用JS设置的COOKIE用了escape,是UTF-8,但是以%u开头,转成\u就可以
echo isset($_GET['callback']) ? $_GET['callback'] .'('. str_replace('%u', '\\u', $jsonp) .');' : '';
exit;