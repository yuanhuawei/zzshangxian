<?php
defined('PHP168_PATH') or die();

/**
* 复制模板
**/

$this_controller->check_admin_action('template') or exit('0');

if(REQUEST_METHOD == 'POST'){
	$base_dir = isset($_POST['base_dir']) ? $_POST['base_dir'] : '';
	$template = isset($_POST['template']) ? $_POST['template'] : '';
	$template or exit('0');
	
	$file = real_path(TEMPLATE_PATH . $base_dir . $template .'.html');
	$file or exit('0');
	//不能超过TEMPLATE_PATH之外
	@stristr($file, TEMPLATE_PATH) == $file or exit('0');
	
	$dir = str_replace(basename($template), '', $template);
	
	$_POST = p8_stripslashes2($_POST);
	
	$new_template = isset($_POST['new_template']) ? basename(trim($_POST['new_template'])) : '';
	$new_template or exit('0');
	
	$new_file = valid_path(TEMPLATE_PATH . $base_dir . $dir . $new_template .'.html');
	
	!is_file($new_file) or exit('0');
	
	cp($file, $new_file) or exit('0');
	
	exit('1');
}

exit('0');