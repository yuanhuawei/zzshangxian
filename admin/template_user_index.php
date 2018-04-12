<?php
defined('PHP168_PATH') or die();

/**ฯตอณฤฃฐๅ**/
$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	GetGP(array('system'));
	
	$config = $core->get_config($system, '');
	
	include template($core, 'template/template', 'admin');
	
}else{
	

	
	message('done');
	
}

?>