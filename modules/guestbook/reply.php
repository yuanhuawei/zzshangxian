<?php
defined('PHP168_PATH') or die();

$this_controller->check_action($ACTION) or message($P8LANG['no_privilege']);

if(REQUEST_METHOD == 'GET'){
	$id = intval($_GET['id']);
	$rsdb = $this_module->get($id);
	$rsdb['replyer'] || $rsdb['replyer']=$USERNAME;	
	include template($this_module,'reply');
	exit;
}elseif(REQUEST_METHOD == 'POST'){
	$id = intval($_POST['id']);
	$postdb['replytime']=P8_TIME;
	$postdb['replyer']= $_POST['replyer'] ? html_entities(from_utf8($_POST['replyer'])) : $USERNAME;
	$postdb['reply'] = html_entities(from_utf8($_POST['reply']));
	$this_module->update($postdb,$id);
	$rsdb=$this_module->get($id);
	$replytime = date("Y-m-d H:i:s",$rsdb['replytime']);
	echo "<div class='border3 mtop'>$rsdb[reply]<p class='replyer'>".$P8LANG['guestbook']['replyer'].": $rsdb[replyer] &nbsp;".$P8LANG['guestbook']['replytime'].": $replytime</p></div>";
	exit;
}