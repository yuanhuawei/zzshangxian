<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action('poller') or message('no_privilege');

P8_AJAX_REQUEST or message('ask_error');

load_language($this_system, 'admin');

if(REQUEST_METHOD == 'GET'){

	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

	if(empty($id) || !$this_controller->check_exists_poller(array('id'=>$id))){
		message('ask_error');
	}

	$select = select();
	$select->from($this_module->table_poller . ' AS A','A.*');
	$select->inner_join($this_module->table_data . ' AS B', 'B.content AS answer_content', 'B.id=A.aid');
	$select->in('A.id',$id);
	//echo $select->build_sql();
	$data = &$core->select($select, array('single' => true));

	include template($this_module, 'view_poller', 'admin');

}
elseif(REQUEST_METHOD == 'POST'){

	$json = $this_controller->set_poller_handler($_POST) or die();
	echo jsonencode($json);
	exit;

}