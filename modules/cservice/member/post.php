<?php
defined('PHP168_PATH') or die();
GetGP(array('mid','page','action','iddb','job'));

if(REQUEST_METHOD == 'GET'){
	$category = $this_module->CONFIG['cs_category'];
	$attachment_hash = unique_id(16);
    $data=array('title'=>'','site'=>'','ip'=>'','content'=>'','mobilephone'=>'','sendmsg'=>'','category'=>'',);
	include template($this_module, "post");
}else if(REQUEST_METHOD=='POST'){
	$this_controller->add(&$_POST);
	message('done',$this_router.'-list',1);
}
?>