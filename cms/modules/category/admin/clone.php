<?php
defined('PHP168_PATH') or die();

/**
* ¿ËÂ¡À¸Ä¿
**/

$this_controller->check_admin_action($ACTION) or exit('[]');


if(REQUEST_METHOD == 'POST'){
	
	@set_time_limit(0);
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$id or exit('0');
	
	$to_id = isset($_POST['to_id']) ? intval($_POST['to_id']) : 0;
	
	$this_module->clonecat($id, $to_id);

	exit('1');
}