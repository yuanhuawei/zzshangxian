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
	$select->from("{$this_module->table_picture} AS p", 'p.url,p.summary');
	$select->in('id', $id);
	$picture = $core->select($select,array('single'=>true));
	$picture =attachment_url($picture);
	if(isset($picture['summary']))
	$picture['summary'] = preg_replace("/\<br\/\>/","\n", $picture['summary']);
	
	exit(jsonencode($picture));

}else{

	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$id or exit('0');

	$summary = isset($_POST['summary']) ? mb_convert_encoding(preg_replace("/\n/","<br/>",trim($_POST['summary'])),$core->CONFIG['page_charset'],"auto") : '';
	if(empty($summary))
	exit('0');
	
	$url = isset($_POST['url']) ? attachment_url(trim($_POST['url']),true): '';

	if($DB_master->query("UPDATE {$this_module->table_picture} SET url='{$url}',summary='{$summary}' WHERE id={$id}"))
	exit('1');

	exit('0');
}

?>