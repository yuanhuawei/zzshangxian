<?php
defined('PHP168_PATH') or die();

/*
线下付款
*/

class P8_Pay_offline{

var $gateway;			
var $pay;				//支付模块的引用
var $order;				//订单

function P8_Pay_offline(&$pay, $config, &$order){
	
	$this->pay = &$pay;
	$this->order = &$order;
	
	$this->gateway = $pay->controller .'-pay_offline';
}

/**
* 生成支付代码
* @param array $order 订单信息
**/
function pay(){
	
	return array(
		'method' => 'get',
		'gateway' => $this->gateway,
		'params' => array(
			'order_NO' => $this->order['NO']
		)
	);
}

/**
* 处理通知
**/
function notify($status){
	//线下支付直接标记己付款,由管理员去审核银行情况
	return array(
		'status' => $status,
		'amount' => $this->order['amount'],
		'number' => $this->order['number'],
		'order_NO' => $this->order['NO'],
		'timestamp' => P8_TIME
	);
}

}