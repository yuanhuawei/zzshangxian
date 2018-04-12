<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action('item') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	$iid = isset($_GET['iid'])? intval($_GET['iid']) : '';

	$select = select();
	$select->from($this_module->title_table, '*');
	$select->in('iid', $iid);
	$select->order('`display_order` ASC');

	$list = $core->list_item(
		$select,
		array(
			'page_size' => 0,
			'ms' => 'master'
		)
	);

	include template($this_module, 'titles', 'admin');

}else if(REQUEST_METHOD == 'POST'){
	//批量修改字段的排序
	$display_order = isset($_POST['_display_order']) && is_array($_POST['_display_order']) ? array_map('intval', $_POST['_display_order']) : array();
	
	foreach($display_order as $id => $order){
		$DB_master->update(
			$this_module->title_table,
			array(
				'display_order' => $order
			),
			"id = '$id'"
		);
	}
	
	message('done',$this_router.'-titles?iid='.$_POST['iid']);
	

}