<?php
defined('PHP168_PATH') or die();

/**
* 充值记录
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$NO = isset($_GET['NO']) ? preg_replace('/[^a-zA-Z0-9]/', '', $_GET['NO']) : '';
	
	$select = select();
	$select->from($this_module->TABLE_ .'recharge');
	$select->order('id DESC');
	
	$page_url = $this_url .'?page=?page?';
	
	if(strlen($NO)){
		$select->like('order_NO', $NO, 'left');
		$page_url .= '&NO='. urlencode($NO);
	}else{
		
	}
	
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page = max(1, $page);
	
	$page_size = 20;
	$count = 0;
	$list = $core->list_item(
		$select,
		array(
			'page' => &$page,
			'count' => &$count,
			'page_size' => $page_size
		)
	);
	
	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => $page_size,
		'url' => $page_url
	));
	
	include template($this_module, 'recharge', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	//修改充值状态,一般用于线下汇款,AJAX调用
	
	$id = isset($_POST['id']) ? filter_int($_POST['id']) : 0;
	$id or exit('[]');
	
	$query = $DB_master->query("SELECT * FROM {$this_module->TABLE_}recharge WHERE id IN(". implode(',', $id) .") AND status = '0'");
	
	//调用支付模块回调
	$pay = &$core->load_module('pay');
	$ret = array();
	while($data = $DB_master->fetch_array($query)){
		$pay->update_order_status($data['order_NO'], $pay->STATUS['TRADE_SUCCESS']) && $ret[] = $data['id'];
	}
	
	exit(p8_json($ret));
	
}