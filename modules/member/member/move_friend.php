<?php
defined('PHP168_PATH') or die();

if(REQUEST_METHOD == 'POST'){
	$fuid = isset($_POST['fuid']) ? filter_int($_POST['fuid']) : array();
	$fuid or exit('[]');
	
	$cid = isset($_POST['cid']) ? intval($_POST['cid']) : 0;
	
	$this_module->move_friend($fuid, $cid) or exit('[]');
	
	exit(jsonencode($fuid));
}
exit('[]');