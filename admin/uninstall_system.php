<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'POST'){

	$system = isset($_POST['system']) ? $_POST['system'] : '';

	isset($core->systems[$system]) or message('no_such_system');

	$this_system = &$core->load_system($system);

	require PHP168_PATH .'install/uninstall_system.php';

	cache_system_module();

	message('done');
}