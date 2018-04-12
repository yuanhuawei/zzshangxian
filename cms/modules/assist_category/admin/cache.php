<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$MODEL = '';
	
	include template($this_module, 'cache', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	@set_time_limit(0);
	
	//Ìø»Ø×Ü»º´æ
	!empty($_POST['_all_cache_']) && message($BACKTO_ALL_CACHE);
	
	$this_module->cache();
	
	message('done');
}