<?php
defined('PHP168_PATH') or die();
$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){



$data['parent'] = isset($_GET['parent']) ? $_GET['parent'] : 0;
$json = $this_module->category->get_json();
$rsdb['templatestyle']=(!empty($this_module->CONFIG['template']) && is_dir(TEMPLATE_PATH.$this_module->CONFIG['template'].'/core/'.$this_module->name.'/main/'))?$this_module->CONFIG['template']:'default';
include template($this_module, 'add', 'admin');	
	
}else if(REQUEST_METHOD == 'POST'){
	
	$id=$this_controller->add($_POST) or message('fail');
	
	message(
		array(
			array('sp_to_edit', $this_router.'-edit?id='.$id),
			array('sp_to_list', $this_router.'-list'),
			array('sp_to_view', $this_module->controller .'-view-id-'.$id , '_blank'),
			array('sp_to_add', $this_router.'-add')
		),
		$this_router.'-list',
		10000
	);
}