<?php
defined('PHP168_PATH') or die();

$IS_ADMIN or message('no_privilege');


if(REQUEST_METHOD == 'POST'){
	
	define('NO_ADMIN_LOG', true);
	
	$cid = isset($_POST['cid']) ? $_POST['cid'] : '';
	$cid or exit('-1');

	$cid = intval($cid);
	$cid or exit('--1');
	
	$ret = $DB_slave->fetch_one("SELECT id FROM $this_system->item_table WHERE cid='$cid' LIMIT 1");
	if(empty($ret['id']))$ret['id']='-1';
	exit($ret['id']);
}