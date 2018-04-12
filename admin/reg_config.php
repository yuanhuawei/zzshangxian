<?php
defined('PHP168_PATH') or die();

/**
* 修改注册配置
**/

$this_controller->check_admin_action('config') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	load_language($core, 'config');
	//$member=&$core->load_module('member');
	//load_language($member, 'config');
	$config = $core->get_config('core', 'member');
	
	$safe = &$config['safe'];
	
	include template($core, 'config/reg_config', 'admin');
}else if(REQUEST_METHOD == 'POST'){
	
	$_POST = p8_stripslashes2($_POST);
	
	$config = isset($_POST['config']) && is_array($_POST['config']) ? $_POST['config'] : array();
	
	//验证问题
	$questions = isset($_POST['safe']['questions']) ? (array)$_POST['safe']['questions'] : array();
	$answers = isset($_POST['safe']['answers']) ? (array)$_POST['safe']['answers'] : array();
	
	$safe = array();
	foreach($questions as $k => $v){
		$question = trim($v);
		if(empty($question)) continue;
		
		$answer = trim($answers[$k]);
		if(empty($answer)) continue;
		$safe[$question] = $answer;
	}
	$config['safe'] = $safe;
	
	$orig_admin_controller = $core->CONFIG['admin_controller'];
	$member=&$core->load_module('member');
	$member->set_config($config);
	
	
	message('done', $this_url);
}