<?php
defined('PHP168_PATH') or die();

$this_controller->check_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){

}elseif(REQUEST_METHOD == 'POST'){
	$id = intval($_POST['id']);
	if($id && $this_module->get($id)){
		$where="id ='$id'";
		$yz =1;
		$status =$this_module->verify($where,$yz);
		exit($id);
	}
}