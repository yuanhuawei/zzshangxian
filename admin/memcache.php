<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	load_language($core, 'config');
	
	$config = $core->get_config('core', '');
	$info = include($core->path .'#.php');
	
	include template($core, 'memcache', 'admin');

}else if(REQUEST_METHOD == 'POST'){
	
	$config = isset($_POST['config']) && is_array($_POST['config']) ? $_POST['config'] : array();
	$host = isset($config['memcache']['server']['host']) ? (array)$config['memcache']['server']['host'] : array();
	$port = isset($config['memcache']['server']['port']) ? (array)$config['memcache']['server']['port'] : array();
	$config['memcache']['server'] = array();
	foreach($host as $k => $v){
		if(!( $v = trim(html_entities($v)) )) continue;
		if(empty($port[$k])) continue;
		
		$config['memcache']['server'][$v.':'.$port[$k]] = array('host' => $v, 'port' => $port[$k]);
	}
	
	$core->set_config($config);
	
	message('done');
}