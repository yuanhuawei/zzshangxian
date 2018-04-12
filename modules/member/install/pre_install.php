<?php
defined('PHP168_PATH') or die();



//允许注册
$this_module->set_config(array(
	'register' => array(
		'enabled' => 1,
		'captcha' => 0,
		'question_enabled' => 0
	),
	'safe'=>array(
		'1+1' => 2,
		'site name' => 'php168',
		'1+2+3+4+...+100' => 5050
	)
));

//开启上传功能
$uploader = &$core->load_module('uploader');
require $uploader->path .'inc/enables.php';