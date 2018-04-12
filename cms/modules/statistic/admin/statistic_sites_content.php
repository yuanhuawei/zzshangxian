<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(!isset($core->systems['sites']))message('sites not installed');

if(REQUEST_METHOD == 'GET'){

	$SITE = $core->load_system('sites');
    $sites = $SITE->get_sites();
    $sites = p8_json($sites);

	$years= range(date("Y"),date("Y")-100);
	$months= range(01,12);

	include template($this_module, 'statistic_sites_content', 'admin');
}elseif(REQUEST_METHOD == 'POST'){
	
	$act = isset($_POST['act'])? $_POST['act'] : '';
	$year = intval($_POST['year']);
	$month = intval($_POST['month']);
	$model = $_POST['model'];
	$cid = intval($_POST['cid']);
	
	if($act=='query'){
		$data = $this_module->getStaticSitesContent($year,$month,$cid,$model);
		echo json_encode($data);
		exit;
	}elseif($act=='stat'){
		if(!$year)
		exit('false');
		
		$static = $this_module->statisticSitesContent($year,$month);
		echo json_encode($static);
		exit;
	}
	elseif($act=='download'){
		$static = $this_module->getStaticSitesContent($year,$month,$cid,$model,true);
		exit;
	}
	

}