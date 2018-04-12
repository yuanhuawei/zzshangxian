<?php
defined('PHP168_PATH') or die();

//挂勾到分类模块去
$this_module->hook($this_system->name, 'category', 'cid');
//挂勾到会员模块去
$this_module->hook('core', 'member', 'uid');


$uploader = &$core->load_module('uploader');
//开启上传功能
require $uploader->path .'inc/enables.php';
//上传模块挂勾到本模块
$uploader->hook($this_system->name, $this_module->name, 'item_id');


$this_module->set_config(array(
	//动态列表页URL规则
	'dynamic_list_url_rule' => '{$module_controller}-list-category-{$id}#-page-{$page}#.shtml',
	//动态内容页URL规则
	'dynamic_view_url_rule' => '{$module_controller}-view-id-{$id}#-page-{$page}#.shtml',
	
	'mobile_dynamic_list_url_rule' => '{$module_mobile_controller}-list-mid-{$id}#-page-{$page}#.html',
	'mobile_dynamic_view_url_rule' => '{$module_mobile_controller}-view-id-{$id}.html',
	
	//个人主页内容页URL规则
	'dynamic_homepage_list_url_rule' => '{$URL}#-page-{$page}#.shtml',
	//列表页缓存时间
	'list_page_cacle_ttl' => 0,
	//内容页缓存时间
	'view_page_cacle_ttl' => 0,
	//允许评论
	'allow_comment' => 1,
	//开启心情功能
	'allow_mood' => 1,
	//导航样式
	'list_navigagion' => 'nav_list02',
	//顶客
	'allow_digg' => true,//顶客
	'first_img_to_frame' => true,//内容第一张图片设为封面
	//评论相关
	'comment' => array(
		'enabled' => 1,
		'require_verify' => 0,
		'page_size' => 20,
		'view_page_size' => 5
	),
	
	//默认关闭sphinx搜索
	'sphinx' => array(
		'enabled' => 0,
		'host' => 'localhost',
		'port' => 3312
	),
	//默认模板
	'template' => 'default',
	//静态化
	'htmlize' => 0
));