<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(!$core->clustered)message('clustered not installed');

if(REQUEST_METHOD == 'GET'){

	$cluster = $core->load_module('cluster');
	$clients = $cluster->clients;
	$path = array();
	
	$models = $this_system->get_models();

	$years= range(date("Y"),date("Y")-100);
	$months= range(01,12);
	
	$json = array(
		'clients' => p8_json($clients),
		'models' => p8_json($models)
	);
	include template($this_module, 'statistic_cluster', 'admin');
}elseif(REQUEST_METHOD == 'POST'){
	
	$act = isset($_POST['act'])? $_POST['act'] : '';
	$year = intval($_POST['year']);
	$month = intval($_POST['month']);
	$model = $_POST['model'];
	$cid = intval($_POST['cid']);
	
	if($act=='query'){
		$data = $this_module->getStaticCluster($year,$month,$cid,$model);
		echo json_encode($data);
		exit;
	}elseif($act=='stat'){
		if(!$year)
		exit('false');
		
		$static = $this_module->statisticCluster($year,$month,$cid,$model);
		echo json_encode($static);
		exit;
	}
	elseif($act=='download'){
		$static = $this_module->getStaticCluster($year,$month,$cid,$model,true);
		exit;
	}
	

}