<?php
defined('PHP168_PATH') or die();

if(REQUEST_METHOD=='POST'){
	
	$id = isset($_POST['id'])? intval($_POST['id']) : '';
	$status = isset($_POST['status'])? intval($_POST['status']) : '';
	$id or exit('[]');
	if($status){
		$sql = $status == 1? 'digg' : 'trample';
	}else{
		exit('[]');
	}
	$this_module->DB_master->update(
		$this_module->table,
		array($sql => "$sql+1"),
		"id = '$id'",
		false
	);
	$result = $this_module->DB_master->fetch_one("SELECT digg, trample FROM $this_module->table WHERE id = '$id'");
	exit(p8_json($result));
}