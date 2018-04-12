<?php
defined('PHP168_PATH') or die();

$uploader = &$core->load_module('uploader');
//开启上传功能
require $uploader->path .'inc/enables.php';