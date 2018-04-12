<?php
defined('PHP168_PATH') or die();

/**
* 心情
**/

//如果关闭了顶帖功能
if(empty($this_module->CONFIG['allow_digg'])) message('access_denied');

if(REQUEST_METHOD == 'GET'){

$iid = isset($_GET['iid']) ? intval($_GET['iid']) : 0;
$iid or exit();

$dig = $DB_slave->fetch_one("SELECT * FROM {$this_module->TABLE_}digg WHERE iid = '$iid'");
if(!$dig){
$dig['digg']=$dig['trample']=0;
}

//unset($tmp['iid']);


include template($this_module, 'digg');
exit;

}else if(REQUEST_METHOD == 'POST'){

$iid = isset($_POST['iid']) ? intval($_POST['iid']) : 0;
$iid or exit();

$did = isset($_POST['did']) ? $_POST['did'] : 0;
$iid or exit();

switch($did){
	case 1:
	$set = "digg";
	break;
	case -1:
	$set = "trample";
	break;
}
$dig = $DB_slave->fetch_one("SELECT * FROM {$this_module->TABLE_}digg WHERE iid = '$iid'");
if($dig){
	$DB_master->update(
		$this_module->TABLE_ .'digg',
		array("$set"=>"$set+1"),
		"iid = '$iid'",
		false
	);
}else{
	$DB_master->insert(
		$this_module->TABLE_ .'digg',
		array("$set"=>"1","iid"=>"$iid"),
		false
	);
}
header('Location: '. HTTP_REFERER);
exit;

}