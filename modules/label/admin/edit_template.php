<?php
defined('PHP168_PATH') or die();

/**
* 编辑模板
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');
	
	define('NO_ADMIN_LOG', true);
	
	$base_dir = isset($_POST['bdir']) ? $_POST['bdir'] : '';
	$template = isset($_POST['tpl']) ? $_POST['tpl'] : '';
	$template or message('no_such_template');
	
	//不允许编辑TEMPLATE_PATH 以外的文件
	$file = real_path(TEMPLATE_PATH . $base_dir . $template .'.html');
	stristr($file, TEMPLATE_PATH) == $file or message('access_denied');
	
	load_language($core, 'config');
	
	$system = '';
	$module = '';
	
	$content = file_get_contents($file);
	
	echo $content;
	exit;

