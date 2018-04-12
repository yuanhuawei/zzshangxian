<?php
defined('PHP168_PATH') or die();

/**
 * ÐÞ¸Ä·ÃÌ¸ÄÚÈÝ
 */

$this_controller->check_admin_action($ACTION) or message('no_privilege');

header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache");
header("Content-type: text/x-json");

if(REQUEST_METHOD == 'GET'){

	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	$id or exit('0');

	$select = select();
	$select->from("{$this_module->table_content} AS c", 'c.content');
	$select->in('id', $id);
	$content = $core->select($select,array('single'=>true));

	if(isset($content['content']))
	$content['content'] = preg_replace("/\<br\/\>/","\n", $content['content']);

	exit(jsonencode($content));

}else{

	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$id or exit('0');

	$content = isset($_POST['content']) ? mb_convert_encoding(preg_replace("/\n/","<br/>",trim($_POST['content'])),$core->CONFIG['page_charset'],"auto") : '';
	if(empty($content))
	exit('0');

	if($DB_master->query("UPDATE {$this_module->table_content} SET content='{$content}' WHERE id={$id}"))
	exit('1');

	exit('0');
}

?>