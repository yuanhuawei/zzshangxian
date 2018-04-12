<?php
defined('PHP168_PATH') or die();

/**
* 修改标签
**/

if(REQUEST_METHOD == 'GET'){
	
	$system = isset($_GET['system']) ? $_GET['system'] : '';
	$module = isset($_GET['module']) ? $_GET['module'] : '';
	$env = isset($_GET['env']) ? $_GET['env'] : '';
	
	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	$id or message('no_such_item');
	
	$data = $LABEL->view($id);
	$data or message('no_such_item');
	
	$option = &$data['option'];
	if(!empty($option['tplcode'])) $option['tplcode'] = stripcslashes($option['tplcode']);
	//构造模型
	if(empty($_REQUEST['model'])){
		$_REQUEST['model'] = $option['model'];
		$this_system->init_model();
	}
	
	if($this_model){
		foreach($this_model['fields'] as $name => $v){
			if($v['orderby']) $order_bys['i.'. $name] = $v['alias'];
		}
		
		$field_json = json_encode($this_model['fields']);
	}
	
	$systems = &$core->systems;
	
	include template($this_module, 'label', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$id or message('no_such_item');
	
	//验证数据
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