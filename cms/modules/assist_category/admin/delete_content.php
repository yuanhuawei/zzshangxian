<?php
defined('PHP168_PATH') or die();
$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	

}else{

	$ids = isset($_POST['id']) ? $_POST['id'] : array();
	if(empty($ids)) exit('[]');
	
	$list = array();
	foreach($ids as $v){
		$temp = array();
		$temp = explode("_",$v);
		if(count($temp) != 2){
			continue;
		}
		$list[] = array('sid'=>intval($temp[0]),'iid'=>intval($temp[1]));
	}
	
	$this_module->delete_list($list) or exit('[]');
	
	exit(jsonencode($ids));
}