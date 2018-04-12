<?php
defined('PHP168_PATH') or die();

/**
* 会员信息的JSONP
**/

//header('Content-type: text/json; charset=utf-8');

if(isset($_GET['callback'])){
	
	$new_messages = 0;
	if($UID){
		$mess = $DB_slave->fetch_one("SELECT COUNT(*) AS `count` FROM {$core->TABLE_}message WHERE sendee_uid = '$UID' AND new = '1'");
		$new_messages = $mess['count'];
	}
	$role_module = $core->load_module('role');
	$role_module->roles || $role_module->get_cache();
	$info = array(
		'id' => $UID,
		'role' => $role_module->roles[$ROLE]['name'],
		'username' => $USERNAME,
		'new_messages' => $new_messages
	);
	$callback = isset($_GET['callback']) ? xss_clear($_GET['callback']) : '';
	exit( $callback.'('. jsonencode($info) .');');
}

exit('null');