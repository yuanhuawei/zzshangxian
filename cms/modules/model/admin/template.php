<?php
defined('PHP168_PATH') or die();

/**
* Éú³ÉÄ£°å
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

$models = $this_system->get_models();

if(REQUEST_METHOD == 'GET'){
	
	$name = isset($_GET['name']) ? $_GET['name'] : '';
	
	if(empty($models[$name])) message('access_denied');
	
	include template($this_module, 'template', 'admin');
	
}if(REQUEST_METHOD == 'POST'){
	
	$name = isset($_POST['name']) ? $_POST['name'] : '';
	
	if(empty($models[$name])) message('access_denied');
	
	$this_module->template_cache($name);
	
	message('done', $this_router .'-list');
}