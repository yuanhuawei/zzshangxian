<?php
defined('PHP168_PATH') or die();

//�����ϴ�����
$uploader = &$core->load_module('uploader');
require $uploader->path .'inc/enables.php';

//�ϴ�ģ��ҹ�
$uploader->hook('core', $this_module->name, 'item_id');