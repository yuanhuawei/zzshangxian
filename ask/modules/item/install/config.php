<?php
defined('PHP168_PATH') or die();

$this_module->set_config(
	array(
		'htmlize' => 0,
		'dynamic_list_url_rule' => '{$module_controller}-list-category-{$id}#-page-{$page}#.html',
		'dynamic_view_url_rule' => '{$module_controller}-view-id-{$id}.html'
	)
);