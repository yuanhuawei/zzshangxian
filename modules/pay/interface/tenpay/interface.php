<?php
defined('PHP168_PATH') or die();

class P8_Pay_tenpay{

var $gateway;
var $pay;
var $order;

function P8_Pay_tenpay(&$pay, $config, &$order){
	$this->pay = &$pay;
	$this->order = &$order;
}

function notify($status){
	if($this->notify_verify()){
		return array(
			'status' => $status
		);
	}
	return null;
}

function pay(){
	
}

function notify_verify(){
	
}

}