<?php

/**
* 投放广告
**/

message('暂不开放');

$this_controller->check_action($ACTION) or message('no_privilege');

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
	
	$_POST['credit'] = 0;
	if($ad['expense_type'] == 'day'){
		//按天计费,检查余额
		$need = $ad['credit_type'] * $ad['credit'];
		$credit = $core->get_credit($UID);
		
		if(empty($core->credits[$ad['credit_type']]) || $credit[$ad['credit_type']] < $need){
			message('not_enough_credit');
		}
		
		$_POST['credit'] = $need;
		
		$day = isset($_POST['day']) ? intval($_POST['day']) : 1;
		$day = max(1, $day);
		$day = min($ad['day'], $day);
		
		list($Y, $m, $d, $H, $i, $s) = explode('|', date('Y|m|d|H|i|s', P8_TIME));
		$_POST['expire'] = date( 'Y-m-d H:i:s', $time = mktime(0, 0, 0, $m, $d + $day, $Y) );
	}
	
	$_POST['verified'] = $_POST['showing'] = empty($ad['verify']) ? 1 : 0;
	
	$this_controller->add_buy($_POST) or message('fail');
	
	$core->update_credit($UID, array($ad['credit_type'] => -$need));
	
	message('done');
	
}