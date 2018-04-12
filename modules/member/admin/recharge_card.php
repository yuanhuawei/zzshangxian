<?php
defined('PHP168_PATH') or die();

/**
* ³äÖµ¿¨
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$id = isset($_GET['id']) ? intval($_GET['id']) : '';
	
	$select = select();
	$select->from($this_module->TABLE_ .'recharge_card');
	$select->order('id DESC');
	
	$page_url = $this_url .'?page=?page?';
	
	if(strlen($id)){
		$select->like('id', $id, 'left');
		$page_url .= '&id='. $id;
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
	
	include template($this_module, 'recharge_card', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;
	$quantity > 0 or message('access_denied');
	$num = isset($_POST['num']) ? intval($_POST['num']) : 0;
	$num > 0 or message('access_denied');
	
	$credit_type = isset($_POST['credit_type']) && isset($core->credits[$_POST['credit_type']]) ? $_POST['credit_type'] : 0;
	$credit_type or message('access_denied');
	
	$cards = array();
	for($i = 0; $i < $num; $i++){
		$cards[] = array(
			'sn' => unique_id(16),
			'credit_type' => $credit_type,
			'quantity' => $quantity,
			'occupied' => 0,
			'used' => 0
		);
	}
	
	/*$max_id = $DB_master->fetch_one("SELECT MAX(id) FROM {$this_module->TABLE_}recharge_card");
	
	$this_module->set_config(array('last_recharge_card_max_id' => $max_id));*/
	
	$DB_master->insert(
		$this_module->TABLE_ .'recharge_card',
		$cards,
		array(
			'multiple' => array('sn', 'credit_type', 'quantity', 'occupied', 'used')
		)
	);
	
	message('done');
	
}