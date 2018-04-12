<?php
defined('PHP168_PATH') or die();

/*
线下付款
*/

class P8_Pay_credit{

var $gateway;			
var $pay;				//支付模块的引用
var $order;				//订单的引用

function P8_Pay_offline(&$pay, $config, &$order){
	
	$this->pay = &$pay;
	$this->order = &$order;
	
	$this->gateway = $pay->controller .'-credit';
}

/**
* 生成支付代码
* @param array $order 订单信息
**/
function pay($order){
	
	return array(
		'method' => 'get',
		'gateway' => $this->gateway,
		'params' => array(
			'order_NO' => $this->gateway
		)
	);
}

/**
* 处理通知
**/
function notify($status){
	
	if($status !== null){
		//非用户支付
		return array(
			'status' => $status,
			'amount' => $this->order['amount'],
			'number' => $this->order['number'],
			'timestamp' => P8_TIME
		);
	}
	
	//获取用户的剩余积分
	$credits = $core->get_credit($this->order['buyer_uid']);
	
	if($credits[$this->order['notify']['credit_type']] < $this->order['notify']['credit']){
		//积分不够
		return null;
	}
	
	//减少积分
	if(
		$DB_master->update_credit(
			$this->order['buyer_uid'],
			array($this->order['notify']['credit_type'] => -$this->order['notify']['credit'])
		)
	){
		//余额支付
		return array(
			'status' => 1,
			'amount' => '',
			'number' => '',
			'order_NO' => $this->order['NO'],
			'timestamp' => P8_TIME
		);
	}
	
	return null;
}

}