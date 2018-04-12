<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action('list') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){

	$id = isset($_GET['id'])? $_GET['id'] : '';
	!empty($id) or message('no_such_item');
	
	$datas = $this_module->get_data($id);
	$data = $datas['data'];
	$addon = $datas['addon'];
	
	$item = $this_module->get_item($data['iid']);
	$titles = $this_module->get_titles($data['iid']);
	
	include template($this_module, 'view', 'admin');
	
	//echo '<pre>';
	//print_r($item);
	//print_r($titles);
	//print_r($datas);

}else if(REQUEST_METHOD == 'POST'){
	$this_controller->update_item($_POST);	
	message('done',$this_router.'-item');	
}