<?php
defined('PHP168_PATH') or die();
/**
 * É¾³ý·ÃÌ¸ÄÚÈÝ
 */
$this_controller->check_admin_action($ACTION) or message('no_privilege');

header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache");
header("Content-type: text/x-json");

if(REQUEST_METHOD == 'GET'){
	exit('[]');
}else{
	$id = isset($_POST['id']) ? filter_int($_POST['id']) : array();
	$id or exit('[]');

	if($this_module->delete_content($id)){
		exit(jsonencode($id));
	}
	exit('[]');
}

?>