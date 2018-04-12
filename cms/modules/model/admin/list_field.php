<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){

	$model = isset($_GET['model']) ? $this_controller->valid_name($_GET['model']) : '';
	$model or message('no_such_cms_model');

	$check = $this_module->get_model($model);
	$check or message('no_such_cms_model');

	$select = select();
	$select->from($this_module->field_table, '*');
	$select->in('model', $model);
	$select->order('display_order DESC');

	$list = $core->list_item(
		$select,
		array(
			'page_size' => 0,
			'ms' => 'master'
		)
	);

	include template($this_module, 'list_field', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	//批量修改字段的排序
	$display_order = isset($_POST['_display_order']) && is_array($_POST['_display_order']) ? array_map('intval', $_POST['_display_order']) : array();
	
	foreach($display_order as $id => $order){
		$DB_master->update(
			$this_module->field_table,
			array(
				'display_order' => $order
			),
			"id = '$id'"
		);
	}
	
	$this_module->cache(isset($_POST['model']) ? $_POST['model'] : '');
	
	message('done');
	
}