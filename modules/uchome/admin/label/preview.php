<?php
defined('PHP168_PATH') or die();

/**
* 
**/

if(REQUEST_METHOD == 'POST'){
	
	$_POST = from_utf8($_POST);
	
	require $this_module->path .'admin/label/valid_data.php';
	
	$controller = &$core->controller($LABEL);
	$label = $controller->valid_data($_POST);
	
	require $LABEL->path .'inc/preview.php';
}
