<?php
defined('PHP168_PATH') or die();

//$this_controller->check_action($ACTION) or message('no_privilege');

P8_AJAX_REQUEST or die();

if(REQUEST_METHOD == 'POST'){

	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	if(empty($id) || !$this_controller->check_action('edit') && !$this_controller->check_exists(array('id'=>$id,'uid'=>$UID))){
	exit("['error']");
	}
	$data=array('ids'=>array($id), 'closed'=>1);
	$this_controller -> closed($data)or exit("['error']");
	exit("['done']");
}
exit;