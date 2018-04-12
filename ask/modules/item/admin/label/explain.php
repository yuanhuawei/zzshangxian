<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'POST'){

	require $this_module->path .'admin/label/valid_data.php';
	require $LABEL->path .'inc/explain.php';
}