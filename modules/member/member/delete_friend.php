<?php
defined('PHP168_PATH') or die();

/**
* É¾³ýºÃÓÑ
**/

if(REQUEST_METHOD == 'POST'){
	
	$fuid = isset($_POST['fuid']) ? filter_int($_POST['fuid']) : array();
	$fuid or exit('[]');
	
	isset($_POST['verified']) || $_POST['verified'] = 1;
	$verified = empty($_POST['verified']) ? 0 : 1;
	
	$this_module->delete_friend($fuid, $verified) or exit('[]');
	
	exit(jsonencode($fuid));
	
}