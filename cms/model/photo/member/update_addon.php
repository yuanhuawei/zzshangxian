<?php
/**
* ����׷������
**/
defined('PHP168_PATH') or die();

if(REQUEST_METHOD == 'GET'){
	
	include template($this_module, 'addon_edit');
	
}else if(REQUEST_METHOD == 'POST'){
	
	//���ħ�����ſ���strip��
	$_POST = p8_stripslashes2($_POST);
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$id or message('no_such_item');
	
	$this_controller->update_addon($_POST) or message('fail');
	message('done');
}