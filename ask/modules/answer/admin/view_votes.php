<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action('edit') or message('no_privilege');

P8_AJAX_REQUEST or message('ask_error');

load_language($this_system, 'admin');

if(REQUEST_METHOD == 'GET'){

	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	$total = 0;

	if(empty($id) || !$this_controller->check_exists(array('id'=>$id))){
		message('ask_error');
	}
	
	$select = select();
	$select -> from($this_module->table . ' AS A', 'A.tid,A.vote_good,A.vote_bad');
	$select -> left_join($this_module->table_votes . ' AS V', 'V.*', 'V.aid=A.id');
	$select -> in('A.id', $id);
	$data = $core->select($select, array('single' => true));
	
	$goodvalue = intval($data['vote_good']);
	$badvalue = intval($data['vote_bad']);
	$totalvalue = $goodvalue + $badvalue;
	$total_percentage = $totalvalue>0 ? round($totalvalue/200*100, 2) : 100;
	$good_percentage = $goodvalue>0 ? round($goodvalue/$totalvalue*100, 2) : 100;
	$bad_percentage = $badvalue>0 ? round($badvalue/$totalvalue*100, 2) : 100;

	include template($this_module, 'view_votes', 'admin');

}
elseif(REQUEST_METHOD == 'POST'){

	$json = $this_controller->remove_votes($_POST) or die();
	echo jsonencode($json);
	exit;

}
