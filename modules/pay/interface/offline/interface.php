<?php
defined('PHP168_PATH') or die();

/*
���¸���
*/

class P8_Pay_offline{

var $gateway;			
var $pay;				//֧��ģ�������
var $order;				//����

function P8_Pay_offline(&$pay, $config, &$order){
	
	$this->pay = &$pay;
	$this->order = &$order;
	
	$this->gateway = $pay->controller .'-pay_offline';
}

/**
* ����֧������
* @param array $order ������Ϣ
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
* ����֪ͨ
**/
function notify($status){
	//����֧��ֱ�ӱ�Ǽ�����,�ɹ���Աȥ����������
	return array(
		'status' => $status,
		'amount' => $this->order['amount'],
		'number' => $this->order['number'],
		'order_NO' => $this->order['NO'],
		'timestamp' => P8_TIME
	);
}

}