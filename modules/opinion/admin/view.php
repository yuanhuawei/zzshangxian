<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action('list') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){

	$id = isset($_GET['id'])? $_GET['id'] : '';
	!empty($id) or message('no_such_item');
	$select = select();
	$select -> from($this_module->data_table.' AS d','d.*');
	$select -> left_join($this_module->table.' AS i','i.title as item_title', ' i.id=d.iid');
	$select->in('d.id',$id);
	
	$data = $core->select($select, array('single' => true, 'ms' => 'master'));
	include template($this_module, 'view', 'admin');

}else if(REQUEST_METHOD == 'POST'){
	$this_controller->update_item($_POST);	
	message('done',$this_router.'-item');	
}