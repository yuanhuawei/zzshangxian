<?php
defined('PHP168_PATH') or die();

/**
* 修改好友分组
**/

if(REQUEST_METHOD == 'GET'){
	
	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	$id or message('no_such_item');
	
	$select = select();
	$select->from($this_module->friend_category_table, '*');
	$select->in('id', $id);
	$select->in('uid', $UID);
	
	$data = $core->select($select, array('single' => true));
	$data or message('no_such_item');
	
	include template($this_module, 'edit_friend_category');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$id or message('no_such_item');
	$name = isset($_POST['name']) ? html_entities($_POST['name']) : '';
	
	$this_module->update_friend_category($id, $name) or message('fail');
	
	message('done', $this_router.'-friend_category');
	
}