<?php
defined('PHP168_PATH') or die();
$uploader = &$core->load_module('uploader');
//开启上传功能
require $uploader->path .'inc/enables.php';

$this_module->set_config(array('hong'=>7,'huan'=>3,'undisplay'=>0));
