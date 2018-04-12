<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$system = isset($_GET['system']) ? $_GET['system'] : '';
	$module = isset($_GET['module']) ? $_GET['module'] : '';
	
	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	$id or message('no_such_item');
	
	$data = $LABEL->view($id);
	$data or message('no_such_item');
	
	$option = &$data['option'];
	if(!empty($option['tplcode']))$option['tplcode']=stripcslashes($option['tplcode']);
	$ask_category = &$this_system->load_module('category');
	$ask_category -> get_cache();
	
	$systems = &$core->systems;
	
	include template($this_module, 'label', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$id or message('no_such_item');
	
	require $this_module->path .'admin/label/valid_data.php';
	
	$_POST['option'] = $option;
	//$_POST['content'] = $select;
	
	$controller->update(
		$id,
		$_POST
	);
	
	$viewurl=get_cookie('_fromurl');
	$labelurl=strstr($viewurl,"?")? $viewurl.'&edit_label=1' : $viewurl.'?edit_label=1';
	message(
		array(
			array('gotoview',$viewurl),
			array('gotoedit',$this_router.'-label?action=update&id='.$id),
			array('gotolabel',$labelurl)
		)
	);
}