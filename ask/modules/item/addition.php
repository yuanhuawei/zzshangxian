<?php
defined('PHP168_PATH') or die();

//$this_controller->check_action($ACTION) or message('no_privilege');

P8_AJAX_REQUEST or die();

if(REQUEST_METHOD == 'GET'){

	//补充问题内容最多字符数
	$addition_length = !empty($this_system->CONFIG['addition_length']) ? intval($this_system->CONFIG['addition_length']) : 200;
	
	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

	if(!empty($id) && $this_controller->check_exists(array('id'=>$id,'uid'=>$UID))){
		$allow_post_addition = true;
	}else{
		$allow_post_addition = false;
	}
	
	include template($this_module, 'addition');
}
elseif(REQUEST_METHOD == 'POST'){

	$json = $this_controller->post_addition($_POST) or die();	
	echo jsonencode($json);

}
exit;