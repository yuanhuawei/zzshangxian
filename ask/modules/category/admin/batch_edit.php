<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

//载入问题模块
$item = &$this_system->load_module('item');

load_language($core, 'config');
load_language($this_system, 'admin');

if(REQUEST_METHOD == 'GET'){

	$this_module->cache(false, false);
	$json = $this_module->get_json();
	$ids = isset($_GET['ids']) ? $_GET['ids'] : '';

	if(empty($ids)){
		message('ask_error', HTTP_REFERER, 3);
	}

	if(strpos($ids, ',')){
		$ids = @explode(',', $ids);
		//获取数组第一个ID元素
		$id = intval(array_shift($ids));
		if(!empty($ids) && is_array($ids)){
			$ids = @implode(',', $ids);
		}else{
			$ids = '';
		}
	}else{
		$id = intval($ids);
		$ids = '';
	}

	if(!$this_controller->check_exists(array('id'=>$id))){
		if(empty($ids)){
			message('ask_error', HTTP_REFERER, 3);
		}else{
			message('ask_error', $this_router.'-'.$ACTION."?ids=$ids", 0.1);
		}
	}

	$select = select();
	$select->from($this_module->table, '*');
	$select->in('id',$id);
	$data = $core->select($select, array('single' => true));

	include template($this_module, 'batch_edit', 'admin');

}
elseif(REQUEST_METHOD == 'POST'){
	
	$id = !empty($_POST['id']) ? intval($_POST['id']) : 0;
	$ids = !empty($_POST['ids']) ? $_POST['ids'] : '';

	$this_controller->batch_update($id, $_POST) or message('ask_error', HTTP_REFERER, 3);

	//更新缓存
	$this_module->cache();

		message('done', $this_router.'-list', 3);
	

}