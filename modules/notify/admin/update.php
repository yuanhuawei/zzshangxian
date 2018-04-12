<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	$id or message('no_such_item');
	
	$data = $this_module->view($id);
	$data or message('no_such_item');
	
	include template($this_module, 'edit', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$id or message('no_such_item');
	
	$_POST = p8_stripslashes2($_POST);
	
	$this_controller->update($id, $_POST);
	
	if(!empty($_POST['send_at_once'])){
		$form = '<form action="'. $this_router .'-send" method="post" id="form"><input type="hidden" name="id" value="'. $id .'" /></form><script type="text/javascript">document.getElementById("form").submit();</script>';
		
		message($form, 0);
	}
	
	message('done');
}