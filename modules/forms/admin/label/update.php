<?php
defined('PHP168_PATH') or die();

/**
* �޸ı�ǩ
**/



if(REQUEST_METHOD == 'GET'){

	$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
	$id or message('no_such_item');
	$data = $LABEL->view($id);
	$data or message('no_such_item');
	$option = &$data['option'];
	if(empty($MODEL)){
		$mid = $option['mid'];
		$this_module->set_model($mid);
		$this_model or message('no_such_cms_model');
	}
	$MODEL = $this_module->MODEL;
	$system = isset($_GET['system']) ? $_GET['system'] : '';
	$module = isset($_GET['module']) ? $_GET['module'] : '';
		
	
	if(!empty($option['tplcode'])) $option['tplcode'] = stripcslashes($option['tplcode']);
	//����ģ��

	
	$systems = &$core->systems;
	
	include template($this_module, 'label', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$id or message('no_such_item');
	
	//��֤����
	require $this_module->path .'admin/label/valid_data.php';
	
	$controller->update($id, $_POST);
	
	message(
		array(
			array('gotoview', str_replace('edit_label=1','',$HTTP_REFERER)),
			array('gotoedit', $this_router.'-label?action=update&id='. $id),
			array('gotolabel', $HTTP_REFERER)
		)
	);
}