<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action('list') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){

	$id = isset($_GET['id'])? $_GET['id'] : '';
	$this_module->delete_data($id);
	message('done',$this_router.'-list');	

}