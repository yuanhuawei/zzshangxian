<?php
defined('PHP168_PATH') or die();

$uploader = &$core->load_module('uploader');
//�����ϴ�����
require $uploader->path .'inc/enables.php';

//�ϴ�ģ��ҹ�
$uploader->hook('core', $this_module->name, 'item_id');

md($this_module->path .'js/');