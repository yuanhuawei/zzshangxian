<?php
defined('PHP168_PATH') or die();

/**
* 剪裁图片
**/

//$this_controller->check_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$url = isset($_GET['url']) ? xss_url($_GET['url']) : '';
	
    $system = isset($_GET['system'])? xss_clear($_GET['system']):xss_clear($_POST['system']);
    $module = isset($_GET['module'])? xss_clear($_GET['module']):xss_clear($_POST['module']);
	
	if(empty($url)) message('no_url_input');
	$_path = str_replace($core->attachment_url, '', $url);
    $att_path = PHP168_PATH . $core->CONFIG['attachment']['path'] .'/';
    $_path = real_path($att_path . $_path);
    if(stristr($_path, $att_path) === false){
        exit('Hack!');
    }
	include template($this_module, 'image_cut');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$url = isset($_POST['url']) ? $_POST['url'] : '';
	
	if(empty($url)) message('no_url_input');
	$_path = str_replace($core->attachment_url, '', $url);
    $att_path = PHP168_PATH . $core->CONFIG['attachment']['path'] .'/';
    $_path = real_path($att_path . $_path);
    if(stristr($_path, $att_path) === false){
        exit('Hack!');
    }
	$x = isset($_POST['x']) ? intval($_POST['x']) : 0;
	$x = max($x, 0);
	$y = isset($_POST['y']) ? intval($_POST['y']) : 0;
	$y = max($y, 0);
	
	$width = isset($_POST['width']) ? intval($_POST['width']) : 0;
	$width = max($width, 0);
	$height = isset($_POST['height']) ? intval($_POST['height']) : 0;
	$height = max($height, 0);
	
	if($width == 0 || $height == 0){
		message('image_cut_size_error');
	}
	
	GetGP(array('system', 'module'));
	
	if($system != 'core' && !get_system($system)) message('access_denied');
	if(!empty($module) && !get_module($system, $module)) message('access_denied');
	
	//$this_controller->check_enabled();
	
	//将文件保存到本地临时文件处理
	$file = @file_get_contents($_path);
	if(!$file) message('file_error');
	
	$src = CACHE_PATH .'tmp/'. unique_id();
	write_file($src, $file);
	
	require PHP168_PATH .'inc/gd.func.php';
	
	//写到本地临时文件并剪裁
	$dest = CACHE_PATH .'tmp/'. unique_id(16) .'.'. file_ext($_path);
    md(CACHE_PATH .'tmp/');
	if(!image_cut($src, $dest, $x, $y, $width, $height)){
		unlink($src);
		message('cut_error');
	}
	
	//交给上传器捕抓到附件
	unlink($src);
	$this_controller->set($system, $module);
	$ret = $this_controller->capture(array(
		'files' => $dest,
		'image_cut' => true
	));
	unlink($dest);
	
	$json = jsonencode(array(
		'action' => 'upload',
		'attachments' => $ret
	));
	
	//交给JSONP
	setcookie('p8_upload_json', $json, 0, '/', $core->CONFIG['base_domain']);
	
	message('<script type="text/javascript">window.close();</script>');
}