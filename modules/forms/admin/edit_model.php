<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action('model') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	$action = isset($_GET['action'])? $_GET['action'] : 'add';
	
	if($action == 'update'){
		$id = isset($_GET['id'])? $_GET['id'] : '';
		!empty($id) or message('no_such_item');
		$select = select();
		$select->from($this_module->model_table, '*');
		$select->in('id', $id);
		
		$data = $core->select($select, array('single' => true, 'ms' => 'master'));
		$data['config'] = mb_unserialize($data['config']);
		$data['verified'] = $data['verified'] !=='' ? explode(",",$data['verified']) : array();
		$config = &$data['config'];
		load_language($core, 'config');
		$core->get_cache('role');
	}
	$template_dir = !empty($this_module->CONFIG['template'])? $this_module->CONFIG['template'].'/core/' : 'default/core/';
	$template_dir .= $this_module->name.'/tpl/';
	include template($this_module, 'edit_model', 'admin');

}else if(REQUEST_METHOD == 'POST'){
	$action = isset($_POST['action'])? $_POST['action'] : 'add';
	
	if($action == 'add')
		$this_controller->add_model($_POST);
	elseif($action == 'update')
		$this_controller->update_model($_POST);	
	message('done',$this_router.'-model');	
}