<?php
//����ͬ��SESSION,��ʵֻ�ǻ����վ��COOKIE�����session id,ǰ���Ǳ���ʹ�ÿ��Թ����SESSION����ԭʼ��SESSION

$SESSION_ID = isset($_GET['SESSION_ID']) ? preg_replace('/[^0-9a-zA-Z]/', '', $_GET['SESSION_ID']) : '';
if(strlen($SESSION_ID) != 16) exit;

header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');

$config = @include dirname(__FILE__) .'/../data/core/core.php';
if(empty($config['cookie'])) exit;
setcookie($config['cookie']['prefix'] .'P8SESSION', $SESSION_ID, -1);
setcookie($config['cookie']['prefix'] .'P8SESSION', $SESSION_ID, 0, '/', $_GET['domain']);