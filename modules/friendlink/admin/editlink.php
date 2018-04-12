<?php
defined('PHP168_PATH') or die();

/**
 * ĞŞ¸ÄÓÑÇéÁ´½Ó
 **/

$this_controller->check_admin_action('link') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){

	$id = isset($_GET['id']) ? $_GET['id'] : 0;
	if(empty($id)) message('error');

	$select = select();
	$select->from($this_module->table_link);
	$select->in('id',$id);

	$link = $core->select($select,array('single'=>true));
	$link['logo'] = attachment_url($link['logo']);
	$select = select();

	$select->from($this_module->table_sort, '*');
	$sorts = $core->list_item($select);

	include template($this_module, 'link_edit', 'admin');
}else if(REQUEST_METHOD == 'POST'){

	if($this_controller->update_link($_POST)){

		message('done',"{$this_router}-link");
	}else{
		
		message('fail');
	}
}