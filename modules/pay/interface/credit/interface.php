<?php
defined('PHP168_PATH') or die();

/*
���¸���
*/

class P8_Pay_credit{

var $gateway;			
var $pay;				//֧��ģ�������
var $order;				//����������

function P8_Pay_offline(&$pay, $config, &$order){
	
	$this->pay = &$pay;
	$this->order = &$order;
	
	$this->gateway = $pay->controller .'-credit';
}

/**
* ����֧������
* @param array $order ������Ϣ
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
* ����֪ͨ
**/
function notify($status){
	
	if($status !== null){
		//���û�֧��
		return array(
			'status' => $status,
			'amount' => $this->order['amount'],
			'number' => $this->order['number'],
			'timestamp' => P8_TIME
		);
	}
	
	//��ȡ�û���ʣ�����
	$credits = $core->get_credit($this->order['buyer_uid']);
	
	if($credits[$this->order['notify']['credit_type']] < $this->order['notify']['credit']){
		//���ֲ���
		return null;
	}
	
	//���ٻ���
	if(
		$DB_master->update_credit(
			$this->order['buyer_uid'],
			array($this->order['notify']['credit_type'] => -$this->order['notify']['credit'])
		)
	){
		//���֧��
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