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
	$sid or exit('[0]');

	$select = select();
	$select->from("{$this_module->table_content} AS c");
	$select->in('c.sid', $sid);
	$select->order('c.posttime ASC');
	$contents = $core->list_item($select);

	exit(jsonencode($contents));
}

?>