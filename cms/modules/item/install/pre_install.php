<?php
defined('PHP168_PATH') or die();

//�ҹ�������ģ��ȥ
$this_module->hook($this_system->name, 'category', 'cid');
//�ҹ�����Աģ��ȥ
$this_module->hook('core', 'member', 'uid');


$uploader = &$core->load_module('uploader');
//�����ϴ�����
require $uploader->path .'inc/enables.php';
//�ϴ�ģ��ҹ�����ģ��
$uploader->hook($this_system->name, $this_module->name, 'item_id');


$this_module->set_config(array(
	//��̬�б�ҳURL����
	'dynamic_list_url_rule' => '{$module_controller}-list-category-{$id}#-page-{$page}#.shtml',
	//��̬����ҳURL����
	'dynamic_view_url_rule' => '{$module_controller}-view-id-{$id}#-page-{$page}#.shtml',
	
	'mobile_dynamic_list_url_rule' => '{$module_mobile_controller}-list-mid-{$id}#-page-{$page}#.html',
	'mobile_dynamic_view_url_rule' => '{$module_mobile_controller}-view-id-{$id}.html',
	
	//������ҳ����ҳURL����
	'dynamic_homepage_list_url_rule' => '{$URL}#-page-{$page}#.shtml',
	//�б�ҳ����ʱ��
	'list_page_cacle_ttl' => 0,
	//����ҳ����ʱ��
	'view_page_cacle_ttl' => 0,
	//��������
	'allow_comment' => 1,
	//�������鹦��
	'allow_mood' => 1,
	//������ʽ
	'list_navigagion' => 'nav_list02',
	//����
	'allow_digg' => true,//����
	'first_img_to_frame' => true,//���ݵ�һ��ͼƬ��Ϊ����
	//�������
	'comment' => array(
		'enabled' => 1,
		'require_verify' => 0,
		'page_size' => 20,
		'view_page_size' => 5
	),
	
	//Ĭ�Ϲر�sphinx����
	'sphinx' => array(
		'enabled' => 0,
		'host' => 'localhost',
		'port' => 3312
	),
	//Ĭ��ģ��
	'template' => 'default',
	//��̬��
	'htmlize' => 0
));