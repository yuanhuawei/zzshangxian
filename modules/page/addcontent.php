<?php
defined('PHP168_PATH') or die();

$this_controller->check_action($ACTION) or message('no_privilege');
if(REQUEST_METHOD == 'GET'){
	GetGP(array('id'));
	$rsdb=$DB_master->fetch_one("SELECT content FROM {$this_module->table} WHERE id = '$id'");
	$rsdb && $data['content']=attachment_url($rsdb['content']);
	include template($this_module, 'addcontent','default');
	exit;
}else if(REQUEST_METHOD == 'POST'){
//如果魔法引号开启strip掉
	$_POST = p8_stripslashes2($_POST);
	$this_controller->addcontent($_POST);
	$tourl=$this_module->controller.'-view-id-'.$_POST['id'];
	message('done',$tourl);
}

?>
