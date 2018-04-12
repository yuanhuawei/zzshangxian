<?php
defined('PHP168_PATH') or die();
$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD=='GET'){

$cates = $this_module->get_category();
$config = $core->get_config('core', 'letter');

include template($this_module,'config','admin');

}else if(REQUEST_METHOD=='POST'){
	
	$_POST = p8_stripslashes2($_POST);
	
	$department = isset($_POST['department'])? $_POST['department'] : array();
	$type = isset($_POST['type'])? $_POST['type'] : array();
	$delete = isset($_POST['delete'])? $_POST['delete'] : array();
	
	if(!empty($delete))
		$this_module->deleteCat($delete);
	
	$this_module->updateCat($department,1);
	$this_module->updateCat($type,2);

	$config = isset($_POST['config']) && is_array($_POST['config']) ? $_POST['config'] : array();
	
	$this_module->set_config($config);
	message('done',$this_url);
}