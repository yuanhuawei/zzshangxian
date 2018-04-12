<?php
defined('PHP168_PATH') or die();

/**
* 支付
**/

if(REQUEST_METHOD == 'GET'){
	
	$NO = isset($_GET['NO']) ? $this_controller->valid_NO($_GET['NO']) : '';
	$NO or message('no_order_NO');
	
	GetGP(array('amount', 'number', 'name', 'seller_uid', 'interface'));
	
	//选择支付方式
	include template($this_module, 'select_interface');
	
}else if(REQUEST_METHOD == 'POST'){
	
	//跳转到支付接口
	$NO = isset($_POST['NO']) ? $this_controller->valid_NO($_POST['NO']) : '';
	$NO or message('no_order_NO');
	
	$interface = isset($_POST['interface']) ? $_POST['interface'] : '';
	$this_module->check_interface($interface) or message('no_such_pay_interface');
	
	$payform = $this_module->pay($NO, $interface);
	if(empty($payform)) message('order_error');
	
	include template($this_module, 'redirect');
}