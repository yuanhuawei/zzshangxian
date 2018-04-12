<?php
defined('PHP168_PATH') or die();

/**
* 充值
**/

if(REQUEST_METHOD == 'GET'){
	
	if(empty($UID)){
		message('not_login', $this_module->U_controller .'-login');
	}
	
	$money = isset($_GET['money']) ? intval($_GET['money']) : 0;
	
	$config = $this_module->CONFIG['recharge'];
	
	include template($this_module, 'recharge');
	
}else if(REQUEST_METHOD == 'POST'){
	
	if(empty($UID)){
		message('not_login', $this_module->U_controller .'-login');
	}
	
	$money = isset($_POST['money']) ? intval($_POST['money']) : 0;
	$config = &$this_module->CONFIG['recharge'];
	if(!isset($config['quantity'][$money])) message('no set');
	
	$credit = $core->credits[$config['credit_type']];
	$name = p8lang(
		$P8LANG['recharge']['order_name'],
		$config['quantity'][$money] . $credit['unit'] . $credit['name']
	);
	
	
	//调用支付模块生成一个订单
	$pay = &$core->load_module('pay');
	$data = array(
		'name' => $name,
		'amount' => $money,
		'number' => 1,
		'NO_prefix' => 'RCG',
		'seller_uid' => 0,
		'buyer_uid' => $UID,
		'buyer_username' => $USERNAME,
		'notify' => array(
			'system' => $SYSTEM,
			'module' => $MODULE,
			'method' => 'pay_recharge',
			'money' => $money,
		)
	);
	$order = $pay->order($data);
	
	//充值记录
	$DB_master->insert(
		$this_module->TABLE_ .'recharge',
		array(
			'order_NO' => $order['NO'],
			'uid' => $UID,
			'username' => $USERNAME,
			'amount' => $config['quantity'][$money],
			'status' => 0,
			'timestamp' => P8_TIME
		)
	);
	
	//跳转到支付接口
	header('Location: '. $pay->controller .'-pay?'.
		'NO='. $order['NO'] .'&name='. urlencode($order['name']) .'&amount='. $order['amount'] .'&number='. $order['number']. '&seller_uid=0');
}