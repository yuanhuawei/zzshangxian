<?php
defined('PHP168_PATH') or die();

md(CACHE_PATH .'label', true);
md(CACHE_PATH .'label/data', true);
md(CACHE_PATH .'label/data/var', true);

$uploader = &$core->load_module('uploader');
//�����ϴ�����
require $uploader->path .'inc/enables.php';

//�ϴ�ģ��ҹ�����ģ��
$uploader->hook('core', 'label', 'item_id');