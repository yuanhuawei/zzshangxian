<?php
defined('PHP168_PATH') or die();

/**
* ���ģ���Ƿ����,ajax����
**/

$IS_ADMIN or exit('0');

GetGP(array('system', 'module', 'template', 'file'));

$template = basename($template);
if(empty($template)){
	exit('0');
}

//����Ƿ��������ļ�
is_file(PHP168_PATH . $core->CONFIG['template_dir'] . $template .'/#.php') or exit('0');

$system = basename($system);

$path = $template .'/'. $system;


$module = basename($module);
if(!empty($module)){
	$path .= '/'. $module;
}

//���ģ��Ŀ¼�Ƿ����
is_dir(PHP168_PATH . $core->CONFIG['template_dir'] . $path) or exit('0');



//��⵽ģ��
exit('1');