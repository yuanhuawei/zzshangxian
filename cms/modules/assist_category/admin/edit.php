<?php
defined('PHP168_PATH') or die();
$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){

	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	if(empty($id)) message($P8LANG['no_such_item!']);
	
	$select = select();
	$select->from($this_module->sort_table);
	$select->in('id',$id);
	$data = $core->select($select,array('single'=>1));
	$json = $this_module->get_json();
	include template($this_module, 'add', 'admin');
}else{
	
	$id = isset($_POST['id'])? intval($_POST['id']) : 0;
	
	if($this_controller->update_sort($_POST)){
		$this_module->cache(false, true, $id);
		message("done","{$this_url}?id={$id}");
	}
	message("fail!","{$this_url}?id={$id}");
}