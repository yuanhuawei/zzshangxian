<?php
defined('PHP168_PATH') or die();

/**
* 修改模型信息,每个模型可以都有自己的配置
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

$name = isset($_REQUEST['name']) ? $this_controller->valid_name($_REQUEST['name']) : '';
$name or message('no_such_item');

$data = $this_module->get_model($name);
$data or message('no_such_item');

if(REQUEST_METHOD == 'GET'){
	
	$select = select();
	$select->from($this_module->table, '*');
	$select->in('name', $name);
	
	$data = $core->select($select, array('single' => true, 'ms' => 'master'));
	$data['config'] = mb_unserialize($data['config']);
	$config = &$data['config'];
	load_language($core, 'config');
	
	include template($this_module, 'edit_model', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$this_controller->update($name, $_POST) or message('fail');
	
	message('done');
}