<?php
defined('PHP168_PATH') or die();

if(REQUEST_METHOD == 'POST'){
	
	isset($_POST['sql']) && $SQL = from_utf8(p8_stripslashes2($_POST['sql']));
	
	require $this_module->path .'inc/explain.php';
}