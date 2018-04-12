<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

load_language($this_system,'admin');

if(REQUEST_METHOD == 'GET'){

	$data = array();

	$data = $this_system->read_statistics();

	include template($this_system, 'statistics', 'admin');

}else if(REQUEST_METHOD == 'POST'){

	
	$item = $this_system->load_module('item');
	$item->cache_statistics();
	$this_system->cache_statistics();
	message('ask_statistics_cache_success', HTTP_REFERER, 3);
	
}
?>