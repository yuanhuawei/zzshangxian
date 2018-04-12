<?php
defined('PHP168_PATH') or die();

/**
* 推送数据,只提供AJAX POST调用
**/

$core->clustered or message('clustered');

$this_controller->check_admin_action($ACTION) or exit('[]');

if(REQUEST_METHOD == 'GET'){
	
	$cluster = &$core->load_module('cluster');
	if(empty($cluster->CONFIG['server']['url'])){
		//没有设置好集群配置
		exit('false');
	}

	$service = $cluster->load_service('client', 'cms_item');
	$category = $service->category();
	
	if(empty($category)) exit('false');

	$json = $category->get_json();
	exit('{"json":'. $json['json'] .',"path":'. $json['path'] .'}');
	
}if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? filter_int($_POST['id']) : array();
	$id or exit('[]');
	$cid = isset($_POST['cid']) ? intval($_POST['cid']) : 0;
	//$cid or exit('[]');
	
	$cluster = &$core->load_module('cluster');
	if(empty($cluster->CONFIG['server']['url'])){
		//没有设置好集群配置
		exit('[]');
	}
	
	//生成数据
	$data = $this_module->cluster_data($id, $cid);
	
	//上推数据
	$count = $cluster->server_call($SYSTEM .'_item', 'push', $data, true);
	
	exit($count > 0 ? jsonencode($id) : '[]');
}
exit('[]');