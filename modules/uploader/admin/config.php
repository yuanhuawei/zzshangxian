<?php
defined('PHP168_PATH') or die();

/**
* ÉÏ´«Ä£¿éÅäÖÃ
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){

	$config = $core->get_config('core', 'uploader');
	$info = include($this_module->path .'#.php');
	load_language($core, 'config');
	load_language($this_module, 'config');
	//$config = array_merge($info, $core->CONFIG, $config);
	
	$filter = &$config['filter'];
	foreach($filter as $ext => $size){
		$filter[$ext] = $size / 1024;
	}
	
	include template($this_module, 'config', 'admin');

}else if(REQUEST_METHOD == 'POST'){
	
	$_POST = p8_stripslashes2($_POST);
	
	$config = isset($_POST['config']) && is_array($_POST['config']) ? $_POST['config'] : array();
	
	$ext = isset($_POST['filter']['ext']) ? (array)$_POST['filter']['ext'] : array();
	$size = isset($_POST['filter']['size']) ? (array)$_POST['filter']['size'] : array();
	
	$filter = array();
	foreach($ext as $k => $v){
		$_ext = trim($v);
		if(empty($_ext)) continue;
		if(in_array(strtolower($_ext),$this_module->deny))message('file_type_deny');
		
		$_size = intval($size[$k]);
		if(empty($_size)) continue;
		
		$filter[$_ext] = $_size * 1024;
	}
	
	$config['filter'] = $filter;
	
	$this_module->set_config($config);
	
	message('done');
}