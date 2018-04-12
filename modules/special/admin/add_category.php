<?php
defined('PHP168_PATH') or die();

/**
* 添加分类
**/
$this_controller->check_admin_action('category') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
$data['parent'] = isset($_GET['parent']) ? $_GET['parent'] : 0;
$json = $this_module->category->get_json();
include template($this_module, 'add_category', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){

		$names = isset($_POST['name']) ? array_filter(array_map('trim', explode("\r\n", $_POST['name']))) : array();
		if(!empty($names)){
		
			$data['type']=isset($_POST['type'])? $_POST['type'] : '2';
			$data['parent'] = isset($_POST['parent']) ? intval($_POST['parent']) : 0;
			//批量添加
			foreach($names as $name){
				$data['name'] = $name;
				$id = $this_module->category->add($data) or message('fail');
				$this_module->category->cache(false, true, $id);
			}
		}
		message("done",$this_router.'-category_list');
}

