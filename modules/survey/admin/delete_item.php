<?php
defined('PHP168_PATH') or die();

$this_controller->check_action('manage') or message($P8LANG['no_privilege']);

if(REQUEST_METHOD == 'GET'){

	$id = intval($_GET['id']);
	if($id && $this_module->get_item($id)){
		$this_module->delete_item($id);
		message('done');
	}
}