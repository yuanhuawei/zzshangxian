<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){

	$core->get_cache('role_group');
	$core->get_cache('role');
	$groups = $core->role_groups;
	$roles = $core->roles;
	
	foreach($roles as $key=>$row){
		$groups[$row['gid']]['roles'][$key] = $row;
	}
	$path = array();
	
	$models = $this_system->get_models();
	
	foreach($core->roles as $v){
		$path[$v['id']][] = $v['gid'];
		$path[$v['id']][] = $v['id'];
	}
	$years= range(date("Y"),date("Y")-100);
	$months= range(01,12);
	$json = array(
		'json' => p8_json($groups),
		'path' => p8_json($path)
	);
	include template($this_module, 'statistic_member', 'admin');
}elseif(REQUEST_METHOD == 'POST'){
	
	$act = isset($_POST['act'])? $_POST['act'] : '';
	$year = intval($_POST['year']);
	$month = intval($_POST['month']);
	$model = $_POST['model'];
	$gid = intval($_POST['gid']);
	$rid = intval($_POST['rid']);
	$cid = $_POST['cid'];
	$cid = preg_replace('/[^0-9,]/', '', $cid);
	$cid = filter_int(explode(',', $cid));
	
	if($act=='query'){
		$page = $_POST['page'];
		$data = $this_module->getStaticMember($gid, $rid, $year, $month, $cid, $model,$page);
		echo p8_json($data);
		exit;
	}elseif($act=='stat'){
		if(!$year)
		exit('false');
		$step = $_POST['step'];
		$static = $this_module->statisticMember($gid, $rid, $year, $month, $cid, $model,$step);
		if($static['step']){
			echo "<script type='text/javascript'>";
				echo "parent.$('#step').val('".$static['step']. "');";
				echo "parent.statistic('".$static['step']."');";
				echo "</script>";
				exit;
		}else{
			echo "<script type='text/javascript'>";
			echo "parent.$('#step').val('0');";
			echo "alert('".$P8LANG['done']."');";
			echo "parent.ajaxing({action: 'hide'});";
			echo "parent.get_data();";
			echo "</script>";
			exit;
		}
	}elseif($act=='download'){
		$uids = $_POST['uids'];
		$this_module->downloadMember($gid, $rid, $year, $month, $cid, $model,$uids);
	}
	

}