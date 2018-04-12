<?php

defined('PHP168_PATH') or die();



$this_controller->check_admin_action('client') or message('no_privilege');



if(REQUEST_METHOD == 'GET'){

	

	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

	$id or message('no_such_item');

	

	$data = $this_module->get($id);

	$data or message('no_such_item');

	

	include template($this_module, 'edit', 'admin');

	

}else if(REQUEST_METHOD == 'POST'){

	

	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

	$id or message('no_such_item');

	

	$_POST = p8_stripslashes2($_POST);

	

	$this_controller->update($id, $_POST);

	

	message('done', $this_router .'-list');

}