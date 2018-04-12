<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	$HTTP_REFERER = urlencode($HTTP_REFERER);
	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	
	//没有ID跳转到添加页面,用于在页面上双击添加的时候
	if(empty($id)){
		header('Location: '. $this_router .'-add?'. $_SERVER['QUERY_STRING'] .'&_referer='. $HTTP_REFERER);
		exit;
	}
	
	$place_holder_width = isset($_GET['place_holder_width']) ? intval($_GET['place_holder_width']) : 100;
	$place_holder_height = isset($_GET['place_holder_height']) ? intval($_GET['place_holder_height']) : 30;
	
	$system = $module = '';

	$data = $this_module->view($id);

	$data or message('no_such_item');
	
	//$this_controller->check_scope($system, $module, $postfix) or message('no_label_scope_privilege');

	$option = &$data['option'];
	if(!empty($option['tplcode'])) $option['tplcode'] = p8_stripslashes2($option['tplcode']);
	
	$systems = &$core->systems;
	
	switch($data['type']){
	
	case 'html':
		include template($this_module, 'type_html', 'admin');
	break;
	
	case 'sql':
		include template($this_module, 'type_sql', 'admin');
	break;
	
	case 'slide'://幻灯片
		include template($this_module, 'type_slide', 'admin');
	break;
	
	case 'flash'://flash
		include template($this_module, 'type_flash', 'admin');
	break;
	
	case 'image'://图片
		include template($this_module, 'type_image', 'admin');
	break;
	
	case 'module_data':
		if($data['source_system'] == 'core'){
			$file = PHP168_PATH .'modules/'. $data['source_module'] .'/admin/label.php';
		}else{
			$file = PHP168_PATH . $data['source_system'] .'/modules/'. $data['source_module'] .'/admin/label.php';
		}
		
		if(!is_file($file)){
			//更换设置
			header('Location: '. $this_router .'-add?'. $_SERVER['QUERY_STRING']);
			exit;
		}
		
		//跳转到模块目录下的admin/label.php
		header('Location: '. $core->admin_controller .'/'. $data['source_system'] .'/'. $data['source_module'] .'-label?'.
			'action=update&id='. $data['id'] .
			'&place_holder_width='. $place_holder_width .'&place_holder_height='. $place_holder_height .
			'&_referer='. $HTTP_REFERER
		);
		exit;
	break;
	
	}
	
}else if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$id or message('no_such_item');
	
	$this_controller->update($id, $_POST);

	message(
		array(
			array('gotoview', str_replace('edit_label=1', '', $HTTP_REFERER)),
			array('gotoedit', $this_router .'-update?id='. $id),
			array('gotolabel', $HTTP_REFERER)
		)
	);
}
