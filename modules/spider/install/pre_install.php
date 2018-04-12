<?php
defined('PHP168_PATH') or die();

//开启上传功能
$uploader = &$core->load_module('uploader');
require $uploader->path .'inc/enables.php';

//上传模块挂钩
$uploader->hook('core', $this_module->name, 'item_id');