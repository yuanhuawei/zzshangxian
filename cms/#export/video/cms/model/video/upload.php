<?php
/**
* SWF�ϴ�����ת�ļ�
**/
if(strtoupper($_SERVER['REQUEST_METHOD']) != 'POST' || !isset($_POST['SESSION_ID'])) exit;

isset($_FILES['Filedata']) && is_array($_FILES['Filedata']) or exit('[]');

$path = dirname(__FILE__);
$config = @include $path .'/../../../data/core/core.php';

if(empty($config['cookie'])){
	exit;
}

$_COOKIE[$config['cookie']['prefix'] .'P8SESSION'] = $_POST['SESSION_ID'];

//��ʼ��
require $path .'/../../../inc/init.php';

//��֤��Ա
member_verify();

$system = basename(dirname($path));
$module = 'item';

$thumb = empty($_POST['thumb']) ? 0 : 1;
$thumb_width = isset($_REQUEST['thumb_width']) ? $_REQUEST['thumb_width'] : 0;
$thumb_height = isset($_REQUEST['thumb_height']) ? $_REQUEST['thumb_height'] : 0;

$uploader = &$core->load_module('uploader');
$controller = &$core->controller($uploader);
$controller->check_action('upload') or exit('[]');

$controller->set($system, $module);

//Ҫ�ϴ����ļ�Ԥ�ȴ����, $_FILES['Filedata']

$ret = $controller->upload(array(
	'files' => $_FILES['Filedata'],
	'thumb_width' => $thumb_width,
	'thumb_height' => $thumb_height,
));

if(empty($ret)) exit('[]');

$json = jsonencode($ret);

exit($json);