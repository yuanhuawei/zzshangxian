<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	$systems = &$core->systems;
	
	$data = array();
	$system = $data['system'] = isset($_GET['system']) ? $_GET['system'] : '';
	$module = $data['module'] = isset($_GET['module']) ? $_GET['module'] : '';
	$site = $data['site'] = isset($_GET['site']) ? $_GET['site'] : '';
	$env = $data['env'] = isset($_GET['env']) ? $_GET['env'] : '';
	$data['type'] = isset($_GET['type']) ? $_GET['type'] : '';
	$postfix = $data['postfix'] = isset($_GET['postfix']) ? $_GET['postfix'] : '';
	$place_holder_width = isset($_GET['place_holder_width']) ? $_GET['place_holder_width'] : '';
	$place_holder_height = isset($_GET['place_holder_height']) ? $_GET['place_holder_height'] : '';
	
	//为了重设标签
	$data['id'] = $id = isset($_GET['id']) ? $_GET['id'] : '';
	$name = isset($_GET['name']) ? $_GET['name'] : '';
	//JS传进来的是用encodeURIComponent编码过,UTF-8的
	empty($_GET['from_js']) || $name = from_utf8($name);
	if(!empty($id) && !empty($name)){$data['name']=$name;}
	
	if($system && $system != 'core' && !get_system($system)){
		message('no_such_system');
	}
	
	if($module && !get_module($system, $module)){
		message('no_such_module');
	}
	
	//$this_controller->check_scope($system, $module, $postfix) or message('no_label_scope_privilege');
	
	load_language($core, 'config');
	
	if(empty($data['type'])){
		$HTTP_REFERER = urlencode($HTTP_REFERER);
		include template($this_module, 'add', 'admin');
		
	}else{
		
		switch($data['type']){
		
		//HTML标签
		case 'html':
			include template($this_module, 'type_html', 'admin');
		break;
		
		//自定义SQL的标签
		case 'sql':
			include template($this_module, 'type_sql', 'admin');
		break;
		
		//幻灯片
		case 'slide':
			include template($this_module, 'type_slide', 'admin');
		break;
		
		//flash
		case 'flash':
			include template($this_module, 'type_flash', 'admin');
		break;
			
		//图片
		case 'image':
			include template($this_module, 'type_image', 'admin');
		break;
		
		//模块数据的标签
		case 'module_data':
			$src_system = isset($_GET['src_system']) ? $_GET['src_system'] : 'core';
			$src_module = isset($_GET['src_module']) ? $_GET['src_module'] : '';
			
			if($src_system != 'core' && !get_system($src_system)){
				message('no_such_system');
			}
			
			if($src_module){
				if(!get_module($src_system, $src_module)){
					message('no_such_module');
				}else{
					if($src_system == 'core'){
						$file = PHP168_PATH .'modules/'. $src_module .'/admin/label.php';
					}else{
						$file = PHP168_PATH . $src_system .'/modules/'. $src_module .'/admin/label.php';
					}
					
					if(is_file($file)){
						//跳转到模块下面的标签编辑页面
						header('Location: '. $core->admin_controller .'/'. $src_system .'/'. $src_module .'-label?'.
							'action=add&system='. $system .'&module='. $module .'&site='. $site .'&env='. $env .'&postfix='. $postfix .
							'&id='.$id.'&name='. urlencode($name) .'&_referer='. urlencode($HTTP_REFERER)
						);
						exit;
					}else{
						message('label_not_available_on_this_module');
					}
				}
			}
			
			$modules = get_modules($src_system);
			
			include template($this_module, 'select_module', 'admin');
		break;
		
		}
	}

}else if(REQUEST_METHOD == 'POST'){
	
	if(!empty($_POST['id'])){
		$id = $_POST['id'];
		$this_controller->update($_POST['id'], $_POST) or message('fail');
	}else{
		$id = $this_controller->add($_POST) or message('fail');
	}
	
	message(
		array(
			array('gotoview', str_replace('edit_label=1','',$HTTP_REFERER)),
			array('gotoedit', $this_router .'-update?id='. $id),
			array('gotolabel', $HTTP_REFERER)
		)
	);
}