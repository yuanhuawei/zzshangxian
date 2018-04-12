<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');
if(REQUEST_METHOD=='GET'){
GetGP(array('id'));
	$id || message('{}');

	$json = $this_module->category->get_json();

	$rsdb=$DB_master->fetch_one("SELECT * FROM {$this_module->table} WHERE id = '$id'");
	$rsdb['banner']=attachment_url($rsdb['banner']);
	$rsdb['frame']=attachment_url($rsdb['frame']);
	$rsdb['templatestyle']=$this_controller->get_templatestyle();
	$rsdb['navigation']=mb_unserialize($rsdb['navigation']);
	$rsdb['template']=mb_unserialize($rsdb['template']);
	include template($this_module, 'add', 'admin');
}else if(REQUEST_METHOD=='POST'){
	GetGP(array('id'));
	unset($_POST['id']);
	$this_controller->update($id,$_POST);
	
	message('done',$this_url.'?id='.$id);
}