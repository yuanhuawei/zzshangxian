<?php

/**
* 修改投放广告
**/

message('暂不开放');

$this_controller->check_action('buy') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$aid = isset($_GET['aid']) ? inval($_GET['aid']) : 0;
	$id or message('no_such_item');
	
	$ad = $this_module->get($aid);
	if(empty($add['buyable'])) message('no_such_item');
	
	include template($this_module, 'buy');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$aid = isset($_POST['aid']) ? inval($_POST['aid']) : 0;
	$id or message('no_such_item');
	
	$ad = $this_module->get($aid);
	if(empty($add['buyable'])) message('no_such_item');
	
	if(!empty($ad['verify'])){
		unset($_POST['verified'], $_POST['showing']);
	}
	
	unset($_POST['expire'], $_POST['credit']);
	
	$this_controller->add_buy($_POST) or message('fail');
	
	message('done');
	
}