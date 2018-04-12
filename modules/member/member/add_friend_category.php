<?php
defined('PHP168_PATH') or die();

if(REQUEST_METHOD == 'GET'){
	
	include template($this_module, 'edit_friend_category');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$name = isset($_POST['name']) ? html_entities($_POST['name']) : '';
	
	if(!strlen($name)){
		P8_AJAX_REQUEST ? exit('0') : message('name', $this_router.'-friend_category');
	}
	
	if($this_module->add_friend_category($name)){
		P8_AJAX_REQUEST ? exit('1') : message('done', $this_router.'-friend_category');
	}
	
	P8_AJAX_REQUEST ? exit('0') : message('fail', HTTP_REFERER);
}