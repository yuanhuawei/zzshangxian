<?php
defined('PHP168_PATH') or die();

$this_module->set_config(array(
	'dynamic_list_url_rule' => '{$module_controller}-list#-page-{$page}#.html',
	'dynamic_post_url_rule' => '{$module_controller}-post-id-{$id}.html',
	'dynamic_view_url_rule' => '{$module_controller}-view-id-{$id}.html'
));
$uploader = &$core->load_module('uploader');
//开启上传功能
require $uploader->path .'inc/enables.php';