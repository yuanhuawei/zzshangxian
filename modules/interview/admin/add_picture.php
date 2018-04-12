<?php
defined('PHP168_PATH') or die();

/**
 * лМ╪см╪ф╛
 */

$this_controller->check_admin_action($ACTION) or message('no_privilege');

header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache");
header("Content-type: text/x-json");

if(REQUEST_METHOD == 'GET'){

	exit('0');

}else{

	$sid = isset($_POST['sid']) ? $_POST['sid'] : 0;
	$sid or exit('0');

	if($this_controller->add_picture($_POST))
	exit('1');

	exit('0');
}

?>