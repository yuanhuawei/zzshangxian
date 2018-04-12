<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');
if(REQUEST_METHOD == 'GET'){
$this_module->get_group_cache();

load_language($core, 'config');

$system_list = &$core->systems;

include template($this_module, 'list_group', 'admin');
}elseif(REQUEST_METHOD == 'POST'){
//ÅÅÐò
	$display_order = isset($_POST['_display_order']) && is_array($_POST['_display_order']) ? array_map('intval', $_POST['_display_order']) : array();

	foreach((array)$display_order as $id => $order){
		$DB_master->update(
			$this_module->group_table,
			array(
				'display_order' => $order
			),
			"id = '$id'"
		);
	}
	$this_module->cache_group();
	message('done');

}