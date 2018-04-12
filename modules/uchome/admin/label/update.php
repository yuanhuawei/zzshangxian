<?php
defined('PHP168_PATH') or die();

/**
* 修改标签
**/

if(REQUEST_METHOD == 'GET'){
	
	$system = isset($_GET['system']) ? $_GET['system'] : '';
	$module = isset($_GET['module']) ? $_GET['module'] : '';
	
	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	$id or message('no_such_item');
	
	$data = $LABEL->view($id);
	$data or message('no_such_item');
	
	$option = &$data['option'];
	isset($types[$option['type']]) or message('access_denied');
	
	$json = $CACHE->read('core/modules', $MODULE, 'forums_json');
	
	if(!empty($option['tplcode'])) $option['tplcode'] = stripcslashes($option['tplcode']);
	$type = $option['type'];
	$order_bys = $order_bys[$type];
	
	include template($this_module, 'label_'. $option['type'], 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$id or message('no_such_item');
	
	//验证数据
	require $this_module->path .'admin/label/valid_data.php';
	isset($types[$option['type']]) or message('access_denied');
	
	$controller->update($id, $_POST);
	
	message(
		array(
			array('gotoview', str_replace('edit_label=1','',$HTTP_REFERER)),
			array('gotoedit', $this_router.'-label?action=update&id='. $id),
			array('gotolabel', $HTTP_REFERER)
		)
	);
}
