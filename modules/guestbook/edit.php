<?php
defined('PHP168_PATH') or die();



if(REQUEST_METHOD == 'GET'){
	$id = intval($_GET['id']);
	$rsdb = $this_module->get($id);
	if($rsdb['uid'] !=$UID && !$this_controller->check_action($ACTION))message($P8LANG['no_privilege']);
	$rsdb['replyer'] || $rsdb['replyer']=$USERNAME;
	
	include template($this_module,'edit');
	exit;
}elseif(REQUEST_METHOD == 'POST'){
	$id = intval($_POST['id']);
	$rsdb=$this_module->get($id);
	if($rsdb['uid'] !=$UID && !$this_controller->check_action($ACTION))message($P8LANG['no_privilege']);
	$postdb['title']= html_entities(from_utf8($_POST['title']));
	$postdb['content'] = html_entities(from_utf8($_POST['content']));
	$this_module->update($postdb,$id);
	$rsdb=$this_module->get($id);

	$rsdb['timestamp']=date('Y-m-d H:i:s',$rsdb['posttime']);
	exit(p8_json($rsdb));

}