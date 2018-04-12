<?php
defined('PHP168_PATH') or die();

$uploader = &$core->load_module('uploader');
//开启上传功能
require $uploader->path .'inc/enables.php';
//上传模块挂勾到本模块
$uploader->hook($this_system->name, $this_module->name, 'form_id');

$this_module->set_config(array(
	'htmlize' => 0,
	'html_post_url_rule' => '{$module_url}/{$name}.'. ($core->CONFIG['ssi'] ? 'shtml' : 'html'),
	'dynamic_list_url_rule' => '{$module_controller}-list-mid-{$id}#-page-{$page}#.html',
	'dynamic_view_url_rule' => '{$module_controller}-view-id-{$id}.html',
	'html_list_url_rule' => '{$module_url}/list_{$id}#-page-{$page}#'. ($core->CONFIG['ssi'] ? 'shtml' : 'html'),
	'html_view_url_rule' => '{$module_url}/{$id}.'. ($core->CONFIG['ssi'] ? 'shtml' : 'html'),
	'status' => array(
		'-1'=>$P8LANG['forms_send_back'],
		'0' =>$P8LANG['forms_no_manage'],
		'1' =>$P8LANG['forms_managing'],
		'9' =>$P8LANG['forms_had_manage'],
		'99' =>$P8LANG['forms_recommend']),
	'view_page_cache_ttl' => 0
));