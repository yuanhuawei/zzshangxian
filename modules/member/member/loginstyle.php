<?php
defined('PHP168_PATH') or die();
xss_check($_GET['id']);
$boxid = !empty($_GET['id']) ? xss_clear($_GET['id']) : '';
$get_sitename = $_GET['site'];
$forward=HTTP_REFERER;
if(!$boxid){
	include template($this_module, 'login/'.$style);
}else{
	if($UID){
		$this_module->set_model($ROLE_GROUP);
		$this_module->get_member_info($UID);
	}	
	
	
	 ob_start();
	include template($this_module, 'login/'.$style);
	$show=ob_get_contents();
	ob_end_clean();
	$show=str_replace(array("\n","\r","'"),array("","","\'"),$show); 
	
	if(isset($core->systems['sites']) && !empty($core->systems['sites']['enabled'])){
		$site = $core->load_system('sites');
		if($site->isfromsites()){
		
			//$core->U_controller .='?site='.$site->SITE;
			
			$show = str_replace('u.php"','u.php?site='.$site->SITE.'"',$show);
		}
	}

	echo "$('#".$boxid."').html('$show');";
	exit;
}	
