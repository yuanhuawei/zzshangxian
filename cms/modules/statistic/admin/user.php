<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){

	$models = $this_system->get_models();
	$category = $this_system->load_module('category');
	$category->get_cache(false);
	$path = array();
	
	$models = $this_system->get_models();
	
	foreach($category->categories as $v){
		$parents = $category->get_parents($v['id']);
		foreach($parents as $vv){
			$path[$v['id']][] = $vv['id'];
		}
		$path[$v['id']][] = $v['id'];
	}
	$years= range(date("Y"),date("Y")-100);
	$months= range(01,12);
	
	$uid=$_GET['uid'];
	$username=$_GET['username'];
	
	$json = array(
		'json' => p8_json($category->top_categories),
		'path' => p8_json($path),
		'models' => p8_json($models)
	);
	include template($this_module, 'statistic_data', 'admin');
}elseif(REQUEST_METHOD == 'POST'){
	
	$act = isset($_POST['act'])? $_POST['act'] : '';
	$year = intval($_POST['year']);
	$month = intval($_POST['month']);
	$model = $_POST['model'];
	$cid = intval($_POST['cid']);
	$uid = intval($_POST['uid']);
	
	if($act=='query'){
		$data = $this_module->getStatic($year,$month,$cid,$model,$uid);
		echo json_encode($data);
		exit;
	}elseif($act=='stat'){
		if(!$year)
		exit('false');
		
		$static = $this_module->statistic($year,$month,$cid,$model);
		echo json_encode($static);
		exit;
	}
	elseif($act=='download'){
		$static = $this_module->getStatic($year,$month,$cid,$model,$uid,true);
		exit;
	}
	

}