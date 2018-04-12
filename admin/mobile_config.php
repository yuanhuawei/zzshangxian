<?php
defined('PHP168_PATH') or die();

/**
* ÐÞ¸ÄºËÐÄÅäÖÃ
**/

$this_controller->check_admin_action('config') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	load_language($core, 'config');

	$config = html_entities($core->get_config('core', ''));
	$core->get_cache('credit');
	
	include template($core, 'config/mobile_config', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$_POST = p8_stripslashes2($_POST);
	
	$config = isset($_POST['config']) && is_array($_POST['config']) ? $_POST['config'] : array();
	
	$orig_admin_controller = $core->CONFIG['admin_controller'];
	
	$core->set_config($config);
	if(strpos($config['murl'], $core->url)===false){
		$_domain = str_replace(array('http://','https://'),'',$config['murl']);
		$session_cross_domains = $core->CONFIG['session_cross_domains'];
		if(!array_key_exists($_domain,$session_cross_domains)){
			$session_cross_domains[$_domain] = $domain.'/sync_session.php';
		}
		$core->set_config(array('session_cross_domains'=>$session_cross_domains));	
	}
	
	message('done',$this_url);
}