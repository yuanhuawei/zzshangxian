<?php
defined('PHP168_PATH') or die();

/**
* 清除过期的角色组
**/

$query = $DB_slave->query("SELECT * FROM {$core->TABLE_}member_buy_role WHERE status = '1' AND expire < ". P8_TIME);

$ids = $uids = $comma = '';
while($arr = $DB_slave->fetch_array($query)){
	$uids .= $comma . $arr['uid'];
	$ids .= $comma . $arr['id'];
	$comma = ',';
}

if($uids){
	$DB_master->update(
		$core->TABLE_ .'member_buy_role',
		array(
			'status' => -1
		),
		"id IN ($ids)",
		false
	);
	
	$DB_master->update(
		$core->TABLE_ .'member',
		array(
			'role_id' => 'last_role_id'
		),
		"id IN ($uids)",
		false
	);
	
	delete_session("uid IN ($uids)");
}