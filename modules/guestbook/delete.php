<?php
defined('PHP168_PATH') or die();

$this_controller->check_action($ACTION) or message($P8LANG['no_privilege']);

if(REQUEST_METHOD == 'GET'){

}elseif(REQUEST_METHOD == 'POST'){
	$id = $_POST['id'];
	if($id && $this_module->get($id)){
		$this_module->delete_book("id='$id'");
		exit($id);
	}
}