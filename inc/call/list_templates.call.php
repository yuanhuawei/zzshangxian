<?php
defined('PHP168_PATH') or die();

//P8_Core::list_templates($refresh = false)
	//前台模板
	$handle = opendir(TEMPLATE_PATH);
	$templates = array();
	while(($item = readdir($handle)) !== false){
		if($item == '.' || $item == '..') continue;
		
		if(is_dir(TEMPLATE_PATH . $item) && ($config = @include TEMPLATE_PATH . $item .'/#.php')){
			$templates[$item] = $config['name'];
		}
	}
	
	//会员中心模板
	$path = TEMPLATE_PATH .'member/';
	$handle = opendir($path);
	$member_templates = array();
	while(($item = readdir($handle)) !== false){
		if($item == '.' || $item == '..') continue;
		
		if(is_dir($path . $item) && ($config = @include $path . $item .'/#.php')){
			$member_templates[$item] = $config['name'];
		}
	}
	
	//个人主页模板
	/*
	$path = TEMPLATE_PATH .'homepage/';
	$handle = opendir($path);
	$homepage_templates = array();
	while(($item = readdir($handle)) !== false){
		if($item == '.' || $item == '..') continue;
		
		if(is_dir($path . $item) && ($config = @include $path . $item .'/#.php')){
			$homepage_templates[$item] = $config['name'];
		}
	}
	*/
	//移动模板
	$path = TEMPLATE_PATH .'mobile/';
	$handle = opendir($path);
	$mobile_templates = array();
	while(($item = readdir($handle)) !== false){
		if($item == '.' || $item == '..') continue;
		
		if(is_dir($path . $item) && ($config = @include $path . $item .'/#.php')){
			$mobile_templates[$item] = $config['name'];
		}
	}
	
	$this->set_config(array(
		'templates' => $templates,
		'mobile_templates' => $mobile_templates,
		'member_templates' => $member_templates,
		'homepage_templates' => $homepage_templates
	));
	
	return $templates;