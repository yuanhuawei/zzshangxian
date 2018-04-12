<?php
defined('PHP168_PATH') or die();

$this_module->set_config(
	array(
		'htmlize' => 0,
		'dynamic_list_url_rule' => '{$module_controller}-list.shtml',
		'dynamic_view_url_rule' => '{$module_controller}-view-id-{$id}.shtml',
		'html_view_url_rule' => '{$system_url}/page/{$id}.'. ($core->CONFIG['ssi'] ? 'shtml' : 'html'),
	)
);
$uploader = &$core->load_module('uploader');
//开启上传功能
require $uploader->path .'inc/enables.php';