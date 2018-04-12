<?php
defined('PHP168_PATH') or die();

/**
* 专题页生成静态
**/

$this_controller->check_admin_action('edit') or message('no_privilege');
if(REQUEST_METHOD=='POST'){
GetGP(array('id'));
	//只接受POST
	require_once PHP168_PATH .'inc/html.func.php';
	
	$data = $DB_master->fetch_one("SELECT * FROM {$this_module->table} WHERE id = '$id'");
	$id = $data['id'];
	$file = p8_html_url($this_module, $data, 'view');
	$tourl = p8_url($this_module, $data, 'view');
	$basename = basename($file);
	$path = str_replace($basename, '', $file);
	md($path);
	
	$__view_uri__ = '/index.php/core/special-view-id-{$id}';
	eval('$_SERVER[\'_REQUEST_URI\'] = "'. $__view_uri__ .'";');
	ob_start();
	require PHP168_PATH .'index.php';
	$content = ob_get_clean();

	write_file($file, $content);
	header("location:$tourl");
	exit;

}