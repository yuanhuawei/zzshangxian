<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or exit('[]');

if(REQUEST_METHOD == 'POST'){

	@set_time_limit(600);
	
	$id = isset($_POST['id']) ? $_POST['id'] : array();
	$m = isset($_POST['model']) ? $_POST['model'] : '';
	$id or exit('[e]');

	$id = filter_int($id);
	$id or exit('[h]');
	if($m=='sp'){
		$ret = $this_module->delete($id) or exit('[k]');
	}elseif($m=='ca'){
		$ret = $this_module->category->delete('id IN ('. implode(',', $id) .')') or exit('[k]');
	}
	$this_module->cache();

	exit(jsonencode($ret));
}