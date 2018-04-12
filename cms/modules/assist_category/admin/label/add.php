<?php
defined('PHP168_PATH') or die();

/**
* ��ӱ�ǩ
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$data = array();
	$system = isset($_GET['system']) ? $_GET['system'] : '';
	$module = isset($_GET['module']) ? $_GET['module'] : '';
	
	
	$data = array(
		'system' => $system ? $system : 'core',
		'module' => $module,
		'type' => 'module_data',
		'postfix' => isset($_GET['postfix']) ? $_GET['postfix'] : ''
	);
	//Ϊ�������ǩ
	$data['id']=$id = isset($_GET['id'])? $_GET['id']:'';
	$name = isset($_GET['name']) ? $_GET['name'] : '';
	if(!empty($id) && !empty($name)){$data['name']=$name;}
	
	$json = $this_module->get_json();
	
	$systems = &$core->systems;
	
	if(isset($this_model)){
		$field_json = jsonencode($this_model['fields']);
	}
	
	include template($this_module, 'label', 'admin');
	echo $data['id'];
}else if(REQUEST_METHOD == 'POST'){
	
	$name = isset($_POST['name']) ? $_POST['name'] : '';
	
	//��֤����
	require $this_module->path .'admin/label/valid_data.php';
	
	$_POST['option'] = $option;		//ѡ��
	if(!empty($_POST['id'])){
		$id = $_POST['id'];
		$controller->update($_POST['id'], $_POST) or message('fail');
	}else{
		$id = $controller->add($_POST) or message('fail');
	}
	
	message(
		array(
			array('gotoview', $HTTP_REFERER),
			array('gotoedit', $this_router.'-label?action=update&id='. $id),
			array('gotolabel', $labelurl)
		)
	);
}