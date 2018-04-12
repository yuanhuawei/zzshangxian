<?php

//本模块挂勾到会员模块
$this_module->hook('core', 'member', 'sendee_uid');

//开启上传功能
$uploader = &$core->load_module('uploader');
require $uploader->path .'inc/enables.php';

//上传模块挂钩
$uploader->hook('core', 'message', 'item_id');