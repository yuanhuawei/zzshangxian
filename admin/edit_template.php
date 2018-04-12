<?php
defined('PHP168_PATH') or die();

/**
* �༭ģ��
**/

$this_controller->check_admin_action('template') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$base_dir = isset($_GET['base_dir']) ? trim($_GET['base_dir']) : '';
	$template = isset($_GET['template']) ? trim($_GET['template']) : '';
	$template or message('no_such_template');
	
	//������༭TEMPLATE_PATH ������ļ�
	$file = real_path(TEMPLATE_PATH . $base_dir . $template .'.html');
	$file or message('access_denied');
	stristr($file, TEMPLATE_PATH) == $file or message('access_denied');
	
	load_language($core, 'config');
	
	$system = $module = '';
	
	$content = html_entities(file_get_contents($file));
	
	include template($core, 'edit_template', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	if(file_exists(CACHE_PATH.'deny_edit_template'))message('access_denied');
	
	$base_dir = isset($_POST['base_dir']) ? trim($_POST['base_dir']) : '';
	$template = isset($_POST['template']) ? trim($_POST['template']) : '';
	$template or message('no_such_template');
	//echo TEMPLATE_PATH . $base_dir . $template .'.html';exit;
	$file = real_path(TEMPLATE_PATH . $base_dir . $template .'.html');
	$file or message('access_denied');
	stristr($file, TEMPLATE_PATH) == $file or message('access_denied');
	
	//�����ħ������,ȥ���������
	$content = isset($_POST['content']) ? p8_stripslashes2($_POST['content']) : '';
	$content = preg_replace('/<!--!!.+?!!-->[\r\n]*/', '', $content);
	//����ĸ��û��޸Ĺ�ģ���ע��
	
	$time = date('Y-m-d H_i_s', P8_TIME);
	
	//if(!empty($_POST['backup'])){
		//����һ�������ļ�
		$backup_file = 'backup/'. str_replace(TEMPLATE_PATH, '', $file) . '.'. $time .'.html';
		$dir = dirname($backup_file);
		
		md(TEMPLATE_PATH . $dir);
		cp($file, TEMPLATE_PATH . $backup_file);
	//}
	//$content = preg_replace("/<!--{php168}-->/","<!--{php168}-->\r\n<!--!! modified by $USERNAME at $time !!-->",$content);
	
	write_file($file, $content) or message('fail');
	
	message('done');
	
}