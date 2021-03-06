<?php
defined('PHP168_PATH') or die();

/**
* 添加标签
**/

if(REQUEST_METHOD == 'GET'){
	if(!isset($MODEL) && $models){
		$model = array_shift($omodels);
		$this_module->set_model($model['id']);
		$this_model or message('no_such_cms_model');
		$MODEL = $this_module->MODEL;
	}
	
	$data = array();
	$system = isset($_GET['system']) ? $_GET['system'] : '';
	$module = isset($_GET['module']) ? $_GET['module'] : '';
	
	
	$data = array(
		'system' => $system ? $system : 'core',
		'module' => $module,
		'type' => 'module_data',
		'postfix' => isset($_GET['postfix']) ? $_GET['postfix'] : ''
	);
	//为了重设标签
	$data['id']=$id = isset($_GET['id'])? $_GET['id']:'';
	$name = isset($_GET['name']) ? $_GET['name'] : '';
	if(!empty($id) && !empty($name)){$data['name']=$name;}
	
	$systems = &$core->systems;
	

	include template($this_module, 'label', 'admin');

	
}else if(REQUEST_METHOD == 'POST'){
	
	$name = isset($_POST['name']) ? $_POST['name'] : '';
	
	//验证数据
	require $this_module->path .'admin/label/valid_data.php';
	
	if(!empty($_POST['id'])){
		$id = $_POST['id'];
		$controller->update($_POST['id'], $_POST) or message('fail');
	}else{
		$id = $controller->add($_POST) or message('fail');
	}
	
	message(
		array(
			array('gotoview', str_replace('edit_label=1','',$HTTP_REFERER)),
			array('gotoedit', $this_router.'-label?action=update&id='. $id),
			array('gotolabel', $HTTP_REFERER)
		)
	);
}