<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action('category') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$this_module->category->get_cache(false);
	$path = array();
	foreach($this_module->category->categories as $v){
		$parents = $this_module->category->get_parents($v['id']);
		foreach($parents as $vv){
			$path[$v['id']][] = $vv['id'];
		}
		$path[$v['id']][] = $v['id'];
	}
	
	$json = array(
		'json' => p8_json($this_module->category->top_categories),
		'path' => p8_json($path)
	);

	include template($this_module, 'category_list', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	//批量修改栏目排序
	$display_order = isset($_POST['_display_order']) ? array_map('intval', (array)$_POST['_display_order']) : array();
	
	foreach($display_order as $id => $order){
		$DB_master->update(
			$this_module->category->table,
			array(
				'display_order' => $order
			),
			"id = '$id'"
		);
	}
	
	$this_module->category->cache();
	
	message('done');
	
}