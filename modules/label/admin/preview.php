<?php
defined('PHP168_PATH') or die();

if(REQUEST_METHOD == 'POST'){
	
	$_POST = p8_stripslashes2(from_utf8($_POST));
	
	$label = $this_controller->valid_data($_POST);
	
	require $this_module->path .'inc/preview.php';
}