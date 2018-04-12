<?php
defined('PHP168_PATH') or die();

md(CACHE_PATH .'label', true);
md(CACHE_PATH .'label/data', true);
md(CACHE_PATH .'label/data/var', true);

$uploader = &$core->load_module('uploader');
//开启上传功能
require $uploader->path .'inc/enables.php';

//上传模块挂钩到此模块
$uploader->hook('core', 'label', 'item_id');