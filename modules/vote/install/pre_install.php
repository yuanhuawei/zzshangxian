<?php
defined('PHP168_PATH') or die();



//�����ϴ�����
$uploader = &$core->load_module('uploader');
require $uploader->path .'inc/enables.php';

//�ϴ�ģ��ҹ�����ģ��
$uploader->hook($this_system->name, $this_module->name, 'item_id');