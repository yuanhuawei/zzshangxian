<?php
defined('PHP168_PATH') or die();

/**
* 线下支付
**/

if(REQUEST_METHOD == 'GET'){
	
	load_language($this_module, 'interface/offline');
	
	$NO = isset($_GET['order_NO']) ? $_GET['order_NO'] : '';
	
	include template($this_module, 'pay_offline');
	
}else if(REQUEST_METHOD == 'POST'){
	
	//跳转到支付接口
	$NO = isset($_POST['NO']) ? $this_controller->valid_NO($_POST['NO']) : '';
	$NO or message('no_order_NO');
	
	$order = $this_module->get_order_by_NO($NO);
	$order or message('no_such_item');
	
	$order['notify']['bank'] = isset($_POST['bank']) ? intval($_POST['bank']) : 0;
	if(
		$DB_master->update(
			$this_module->order_table,
			array(
				'notify' => $DB_master->escape_string(serialize($order['notify']))
			),
			"NO = '$NO'". ($UID ? ' AND buyer_uid = \''. $UID .'\'' : ' AND buyer_uid = \'0\' AND ip = \''. P8_IP .'\'')
		)
	){
		message('order_submitted', $core->U_controller);
	}
	
	message('access_denied');
}