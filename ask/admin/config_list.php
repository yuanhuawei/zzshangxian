<?php
defined('PHP168_PATH') or die();

load_language($this_system,'admin');

if(REQUEST_METHOD == 'GET'){

	$config = $core->get_config($this_system->name, '');
	
	$info = include($this_system->path. '#.php');
	
	include template($this_system, 'config_list', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){

	$config = isset($_POST['config']) && is_array($_POST['config']) ? $_POST['config'] : array();
	
	$this_system->set_config($config);
	
	message('done', HTTP_REFERER);
}