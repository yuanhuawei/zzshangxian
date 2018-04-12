<?php
defined('PHP168_PATH') or die();

//P8_Member::pay_recharge(&$pay, $notify){
	
	write_file($this->path .'recharge.notify.txt', var_export($notify, true) ."\r\n", 'a');
	
	if(empty($notify['paid'])){
		return true;	//未付款的状态码均返回成功,一般为即时到账
	}else{
		//支付成功
		$this->DB_master->update(
			$this->TABLE_ .'recharge',
			array(
				'status' => 1,
			),
			"order_NO = '$notify[order_NO]'"
		);
	}
	
	$config = $this->CONFIG['recharge'];
	if(!isset($config['quantity'][$notify['money']])) return false;
	
	$this->core->update_credit(
		$notify['buyer_uid'],
		array($config['credit_type'] => $config['quantity'][$notify['money']])
	);
	
	global $P8LANG;
	$message = &$this->core->load_module('message');
	$data = array(
		'system' => true,
		'username' => $notify['buyer_username'],
		'title' => 'recharge done',
		'content' => 'recharge done',
	);
	$message->send($data);
	
	return true;