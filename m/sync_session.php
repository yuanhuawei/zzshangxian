<?php
//跨域同步SESSION,其实只是获得主站的COOKIE里面的session id,前提是必须使用可以共享的SESSION而非原始的SESSION

$SESSION_ID = isset($_GET['SESSION_ID']) ? preg_replace('/[^0-9a-zA-Z]/', '', $_GET['SESSION_ID']) : '';
if(strlen($SESSION_ID) != 16) exit;

header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');

$config = @include dirname(__FILE__) .'/../data/core/core.php';
if(empty($config['cookie'])) exit;
setcookie($config['cookie']['prefix'] .'P8SESSION', $SESSION_ID, -1);
setcookie($config['cookie']['prefix'] .'P8SESSION', $SESSION_ID, 0, '/', $_GET['domain']);