<?php
defined('PHP168_PATH') or die();

$uploader = &$core->load_module('uploader');
//开启上传功能
require $uploader->path .'inc/enables.php';

//上传模块挂钩
$uploader->hook('core', $this_module->name, 'item_id');

md($this_module->path .'js/');