<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action('category') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$this_module->cache_category(false);
	
	include template($this_module, 'category', 'admin');

}else if(REQUEST_METHOD == 'POST'){
	
	if(!empty($_POST['name'])){
		//添加
		$this_controller->add_category($_POST);
	}
	
	//批量修改名称顺序
	$update = isset($_POST['_update']) ? filter_int($_POST['_update']) : array();
	foreach($update as $id){
		
		$name = isset($_POST['new_name'][$id]) ? html_entities($_POST['new_name'][$id]) : '';
		$order = isset($_POST['order'][$id]) ? intval($_POST['order'][$id]) : 0;
		
		$DB_master->update(
			$this_module->category_table,
			array(
				'name' => $name,
				'display_order' => $order
			),
			"id = '$id'"
		);
	}
	
	$this_module->cache_category();
	
	message('done');
}