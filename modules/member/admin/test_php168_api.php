<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'POST'){
	
	$api = isset($_POST['api']) ? $_POST['api'] : '';
	$ip = isset($_POST['ip']) ? $_POST['ip'] : '';
	$key = isset($_POST['key']) ? $_POST['key'] : '';
	
	$data = urlencode(p8_code(
		serialize(array(
			'action' => 'test',
			'server_id' => $core->CONFIG['server_id'],
			'time' => P8_TIME
		)),
		true,
		$key
	));
	
	$ret = p8_http_request(
		$api,
		P8_API_DATA_NAME .'='. $data,
		'',
		$ip
	);
	echo $ret['body'];
	exit();
}