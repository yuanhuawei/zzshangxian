<?php
defined('PHP168_PATH') or die();


//$this_controller->check_action($ACTION) or die();
if(empty($UID)) die();
if(REQUEST_METHOD=='GET'){
	GetGP(array('id'));
	$ids[]=$id;
	$this_controller->delete_myfavorite($ids);
message('done',$this_router.'-my_favorite');
}else if(REQUEST_METHOD == 'POST'){
	P8_AJAX_REQUEST or die();
	$ids = isset($_POST['ids']) ? $_POST['ids'] : array();
	$json = array();

	if(empty($ids) || !is_array($ids)) die();

	$json = $this_controller->delete_myfavorite($ids);
	
	if(!empty($json)){
		$number = count($json);
		$ask_member = &$this_system->load_module('member');
		$ask_member_controller = &$core->controller($ask_member);
		$ask_member_controller->update_count_favorites($UID, 'cut', $number);
	}

	echo jsonencode($json);
	exit;

}