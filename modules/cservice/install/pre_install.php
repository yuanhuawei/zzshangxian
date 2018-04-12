<?php
defined('PHP168_PATH') or die();
$this_module->set_config(
	array(
		'cs_category' => Array ( '0.461215112494369' => '售后投诉', '0.5945602833545108' => '质量投诉' )
	)
);
$uploader = &$core->load_module('uploader');
//开启上传功能
require $uploader->path .'inc/enables.php';
