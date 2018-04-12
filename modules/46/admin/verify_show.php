<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action('buy') or message('no_privilege');

if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? filter_int($_POST['id']) : array();
	$id or exit('[]');
	$value = empty($_POST['value']) ? 0 : 1;
	
	$action = @$_POST['action'];
	
	switch($action){
	
	case 'verify':
		$data = array('verified' => $value);
	break;
	
	case 'show':
		$data = array('showing' => $value);
	break;
	
	default:
		$data = array('showing' => $value, 'verified' => $value);
	break;
	
	}
	
	$ids = implode(',', $id);
	$query = $DB_master->query("SELECT aid, postfix FROM $this_module->buy_table WHERE id IN($ids)");
	$ad = array();
	while($arr = $DB_master->fetch_array($query)){
		$ad[$arr['aid']][$arr['postfix']] = 1;
	}
	
	$DB_master->update(
		$this_module->buy_table,
		$data,
		"id IN($ids)"
	) or exit('[]');
	
	foreach($ad as $aid => $v){
		foreach($v as $postfix => $vv){
			$this_module->js($aid, $postfix);
		}
	}
	
	exit(p8_json($id));
	
}