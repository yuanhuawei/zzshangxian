<?php
defined('PHP168_PATH') or die();

/**
 * 访谈内容
 */

if(REQUEST_METHOD == 'GET'){
	
	$id = isset($URL_PARAMS) ? intval($URL_PARAMS[0]) : 0;
	$id or message('数据不存在！');
	$select = select();
	$select->from("{$this_module->table_subject} AS s", 's.*');
	$select->in('id', $id);
	$subject = $core->select($select,array('single' => true));
	$subject = attachment_url($subject);

	$select = select();
	$select->from("{$this_module->table_person} AS p", 'p.*');
	$select->in('sid', $id);
	$persons = $core->list_item($select);
	
	include template($this_module, 'view');
}else{
	
	header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
	header("Cache-Control: no-cache, must-revalidate" );
	header("Pragma: no-cache");
	header("Content-type: text/x-json");
	$sid = isset($_POST['sid']) ? $_POST['sid'] : 0;
	$sid or exit('[0]');
	$jsondata = jsonencode($this_controller->add_ask($_POST));
	exit($jsondata);
}

?>