<?php
defined('PHP168_PATH') or die();

/**
* 会员配置自己的支付方式
**/



if(REQUEST_METHOD == 'GET'){
	
	$interface = isset($_GET['interface']) ? $_GET['interface'] : '';
	$config = $this_module->interface_config($interface, $UID);
	
	include template($this_module, 'interface_config/'. $interface);
	
}else if(REQUEST_METHOD == 'POST'){
	
	$_POST = p8_stripslashes2($_POST);
	
	$interface = isset($_POST['interface']) ? $_POST['interface'] : '';
	$config = isset($_POST['config']) ? $_POST['config'] : array();
	
	$this_module->interface_config($interface, $UID, $config);
	
	message('done');
	
}