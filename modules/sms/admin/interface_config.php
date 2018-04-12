<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$interface = isset($_REQUEST['name']) ? basename($_REQUEST['name']) : '';
	
	isset($this_module->interfaces[$interface]) or message('no_such_sms_interface');
	
	$config = $this_module->interfaces[$interface]['config'];
	
	include template($this_module, 'interface_config/'. $interface, 'admin');

}else if(REQUEST_METHOD == 'POST'){
	
	$_POST = p8_stripslashes2($_POST);
	
	$config = isset($_POST['config']) && is_array($_POST['config']) ? $_POST['config'] : array();
	
	$interface = isset($_POST['interface']) ? $_POST['interface'] : '';
	isset($this_module->interfaces[$interface]) or message('access_denied');
	
	if(isset($_POST['enabled'])){
		$enabled = empty($_POST['enabled']) ? 0 : 1;
		
		$this_module->interfaces[$interface]['enabled'] = $enabled;
		$this_module->set_config(array(
			'interfaces' => $this_module->interfaces
		));
		
		exit('1');
		
	}else{
		
		$this_module->interfaces[$interface]['config'] = $config;
		
		$this_module->set_config(array('interfaces' => $this_module->interfaces));
		
		message('done', $this_url .'?name='. $interface);
		
	}
	
}