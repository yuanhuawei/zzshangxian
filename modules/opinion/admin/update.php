<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action('item') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){

	$id = isset($_GET['id'])? $_GET['id'] : '';
	!empty($id) or message('no_such_item');
	$select = select();
	$select->from($this_module->table, '*');
	$select->in('id', $id);
	
	$rsdb = $core->select($select, array('single' => true, 'ms' => 'master'));

	$template_dir = !empty($this_module->CONFIG['template'])? $this_module->CONFIG['template'].'/core/' : 'default/core/';
	$template_dir .= $this_module->name.'/';
	include template($this_module, 'edit', 'admin');

}else if(REQUEST_METHOD == 'POST'){
	$this_controller->update_item($_POST);	
	message('done',$this_router.'-item');	
}