<?php
defined('PHP168_PATH') or die();

/**
 * м╪ф╛ап╠М
 */

$this_controller->check_admin_action($ACTION) or message('no_privilege');

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
	$select->from("{$this_module->table_picture} AS p", 'p.*');
	$select->in('p.sid', $sid);
	$select->order('p.posttime ASC');
	$pictures = attachment_url($core->list_item($select));

	exit(jsonencode($pictures));
}

?>