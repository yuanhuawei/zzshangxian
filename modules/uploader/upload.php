<?php
defined('PHP168_PATH') or die();

$this_controller->check_action($ACTION) or message('no_privilege');


GetGP(array('system', 'module','only'));

if($system != 'core' && !get_system($system)) message('access_denied');
if(!empty($module) && !get_module($system, $module)) message('access_denied');

$count = isset($_GET['count']) ? intval($_GET['count'])+1 : 1;
if($count < 0) $count = 99;

$thumb = empty($_POST['thumb']) ? 0 : 1;
$thumb_width = isset($_REQUEST['thumb_width']) ? $_REQUEST['thumb_width'] : 0;
$thumb_height = isset($_REQUEST['thumb_height']) ? $_REQUEST['thumb_height'] : 0;

$cthumb_width = isset($_REQUEST['content_thumb_width']) ? $_REQUEST['content_thumb_width'] : 0;
$cthumb_height = isset($_REQUEST['content_thumb_height']) ? $_REQUEST['content_thumb_height'] : 0;
$from_word = empty($_REQUEST['from_word']) ? 0 : 1;

$this_controller->set($system, $module);

//禁止上传
//$this_controller->check_enabled() or message('upload_disabled');

if(REQUEST_METHOD == 'GET'){
	
	$filter_json = p8_json(isset($_GET['filter']) ? $_GET['filter'] : $this_controller->filter);
	$swf = empty($_GET['swf']) ? 0 : 1;
	
	include template($this_module, $swf ? 'swfupload' : 'upload', 'default');
	exit;
}else if(REQUEST_METHOD == 'POST'){
	
	if(isset($_POST['action']) && $_POST['action'] == 'capture'){
		//捕抓文件
		isset($_POST['upload_files']) && is_array($_POST['upload_files']) or message('select_upload_file');
		
		$json = $this_controller->capture(array(
			'files' => $_POST['upload_files'],
			'thumb_width' => $thumb_width,
			'thumb_height' => $thumb_height,
			'cthumb_width' => $cthumb_width,
			'cthumb_height' => $cthumb_height,
		));
		
	}else{
		//上传文件
		isset($_FILES['upload_files']) && is_array($_FILES['upload_files']) or message('select_upload_file');
		
		$json = $this_controller->upload(array(
			'files' => $_FILES['upload_files'],
			'thumb_width' => $thumb_width,
			'thumb_height' => $thumb_height,
			'cthumb_width' => $cthumb_width,
			'cthumb_height' => $cthumb_height,
		));
		
	}
	
	$count = count($json);
	
	if(!$count){
		message('no_file_uploaded');
	}
	
	$json = jsonencode(array(
		'action' => 'upload',
		'from_word' => $from_word,
		'attachments' => $json
	));
	
	setcookie('p8_upload_json', $json, 0, '/', $core->CONFIG['base_domain']);
	
	message('click_ok_to_fetch_uploaded_file', '', 0, array($count),0);
}