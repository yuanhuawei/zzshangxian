<?php

//��ģ��ҹ�����Աģ��
$this_module->hook('core', 'member', 'sendee_uid');

//�����ϴ�����
$uploader = &$core->load_module('uploader');
require $uploader->path .'inc/enables.php';

//�ϴ�ģ��ҹ�
$uploader->hook('core', 'message', 'item_id');