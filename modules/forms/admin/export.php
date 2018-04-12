<?php
defined('PHP168_PATH') or die();

/**
* 导出模型
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');
	@set_time_limit(0);
	$mid = isset($_GET['mid']) ? intval($_GET['mid']) : '';
	$this_module->set_model($mid,true) or message('fail');
	$this_module->export($mid) or message('fail');
	
	message('done');
