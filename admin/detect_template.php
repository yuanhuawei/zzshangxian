<?php
defined('PHP168_PATH') or die();

/**
* 检测模板是否存在,ajax调用
**/

$IS_ADMIN or exit('0');

GetGP(array('system', 'module', 'template', 'file'));

$template = basename($template);
if(empty($template)){
	exit('0');
}

//检测是否有描述文件
is_file(PHP168_PATH . $core->CONFIG['template_dir'] . $template .'/#.php') or exit('0');

$system = basename($system);

$path = $template .'/'. $system;


$module = basename($module);
if(!empty($module)){
	$path .= '/'. $module;
}

//检测模板目录是否存在
is_dir(PHP168_PATH . $core->CONFIG['template_dir'] . $path) or exit('0');



//检测到模板
exit('1');