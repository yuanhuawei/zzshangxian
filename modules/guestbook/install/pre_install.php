<?php
defined('PHP168_PATH') or die();

$this_module->set_config(
	array(
		'htmlize' => 0,
		'dynamic_list_url_rule' => '{$module_controller}-list-id-{$id}#-page-{$page}#.shtml',
		'dynamic_view_url_rule' => '{$module_controller}-view-id-{$id}.shtml'
	)
);