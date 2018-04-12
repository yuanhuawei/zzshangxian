<?php
defined('PHP168_PATH') or die();

/**
* 推送数据,只提供AJAX POST调用
**/

$this_controller->check_admin_action('cluster_push') or message('clustered');

$this_controller->check_admin_action($ACTION) or exit('[]');

if(REQUEST_METHOD == 'GET'){
	
	$sites = $core->load_system('sites');
	$stop = $sites->load_module('stop');

	$json = $stop->get_json();
	$allsites  = $sites->get_sites();
	$allsites  = p8_json($allsites);
	exit('{"json":'. $json['json'] .',"path":'. $json['path'] .',"sites":'.$allsites.'}');
	
}if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? filter_int($_POST['id']) : array();
	$id or exit('[]');
	$cid = isset($_POST['cid']) ? intval($_POST['cid']) : 0;
	$push_site = isset($_POST['push_site']) ? $_POST['push_site'] : '';
    $send_time_type = isset($_POST['send_time_type']) ? intval($_POST['send_time_type']) : 0;
	$send_time = isset($_POST['send_time']) ? trim($_POST['send_time']) : 0;
	//$cid or exit('[]');
	$sites = $core->load_system('sites');
	$stop = $sites->load_module('stop');

	//生成数据
	$data = $this_module->sites_data($id, $cid,$push_site, $send_time_type, $send_time);
	
	//上推数据
	$count = $stop->push($data, true);
	
	exit($count > 0 ? jsonencode($id) : '[]');
}
exit('[]');