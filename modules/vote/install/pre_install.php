<?php
defined('PHP168_PATH') or die();



//开启上传功能
$uploader = &$core->load_module('uploader');
require $uploader->path .'inc/enables.php';

//上传模块挂钩到此模块
$uploader->hook($this_system->name, $this_module->name, 'item_id');