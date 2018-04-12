<?php
defined('PHP168_PATH') or die();

md(CACHE_PATH . $this_system->name .'/modules/'. $this_module->name .'/category', true);

$uploader = &$core->load_module('uploader');
//开启上传功能
require $uploader->path .'inc/enables.php';
//上传模块挂勾到本模块
$uploader->hook($this_system->name, $this_module->name, 'item_id');

$this_module->set_config(array(
	'htmlize' => 0,
	'dynamic_list_url_rule' => '{$module_controller}-list-category-{$id}#-page-{$page}#.html',
	'dynamic_view_url_rule' => '{$module_controller}-view-id-{$id}.shtml',
	'html_list_url_rule' => '{$system_url}/special/list_{$id}#-page-{$page}#'. ($core->CONFIG['ssi'] ? 'shtml' : 'html'),
	'html_view_url_rule' => '{$system_url}/special/{$id}.'. ($core->CONFIG['ssi'] ? 'shtml' : 'html'),
	'view_page_cache_ttl' => 0
));