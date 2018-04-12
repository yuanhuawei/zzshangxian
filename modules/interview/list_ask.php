<?php
defined('PHP168_PATH') or die();

/**
 * мЬсяаТят
 */
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache");
header("Content-type: text/x-json");

if(REQUEST_METHOD == 'GET'){

	exit('[]');
}else{

	$sid = isset($_POST['sid']) ? intval($_POST['sid']) : 0;
	$sid or exit('[]');

	$select = select();
	$select->from("{$this_module->table_ask} AS a", 'a.username,a.content,a.posttime');
	$select->in('sid', $sid);
	$select->in('status', 1);
	$asks = $core->list_item($select);

	exit(jsonencode($asks));
}

?>