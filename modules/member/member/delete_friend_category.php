<?php
defined('PHP168_PATH') or die();

/**
* É¾³ýºÃÓÑ·Ö×é
**/

if(REQUEST_METHOD == 'POST'){
	$id = isset($_POST['id']) ? filter_int($_POST['id']) : array();
	$id or exit('[]');
	
	$this_module->delete_friend_category($id) or exit('[]');
	
	exit(jsonencode($id));
}
exit('[]');