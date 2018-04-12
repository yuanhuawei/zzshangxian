<?php
defined('PHP168_PATH') or die();

$this_system->init_model();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){

	$category = &$this_system->load_module('category');
	$category->get_cache();
	
	include template($this_module, 'category_credit_rule', 'admin');

}