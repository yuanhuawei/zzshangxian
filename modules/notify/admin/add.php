<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	include template($this_module, 'edit', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$_POST = p8_stripslashes2($_POST);
	
	$id = $this_controller->add($_POST) or message('fail');
	
	if(!empty($_POST['send_at_once'])){
		$form = '<form action="'. $this_router .'-send" method="post" id="form"><input type="hidden" name="id" value="'. $id .'" /></form><script type="text/javascript">document.getElementById("form").submit();</script>';
		
		message($form, 0);
	}
	
	message('done', $this_router .'-list');
}