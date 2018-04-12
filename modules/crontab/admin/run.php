<?php
defined('PHP168_PATH') or die();

/**
* 手动执行计划任务
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	
	$ADMIN_LOG = array('title' => $P8LANG['run_crontab']);
	
	//$this_module->run($id);
	$crontab_id = $id;
	$crontab = $this_module;
	require $crontab->path .'inc/run.php';
	
	message('done', HTTP_REFERER, 30);
}