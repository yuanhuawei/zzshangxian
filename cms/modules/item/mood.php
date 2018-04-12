<?php
defined('PHP168_PATH') or die();

/**
* 心情
**/

//如果关闭了心情功能
if(empty($this_module->CONFIG['allow_mood'])) exit;

if(REQUEST_METHOD == 'GET'){

$iid = isset($_GET['iid']) ? intval($_GET['iid']) : 0;
$iid or exit();

$tmp = $DB_slave->fetch_one("SELECT * FROM {$this_module->TABLE_}mood_data WHERE iid = '$iid'");

unset($tmp['iid']);

$moods = $CACHE->read($SYSTEM .'/modules', $this_module->name, 'moods');

$max = 0;
$max_id = 0;
$total = 0;
$data = array();
foreach($moods as $id => $m){
	$v = isset($tmp['m'. $id]) ? $tmp['m'. $id] : 0;
	if($v > $max){
		$max = $v;
		$max_id = $id;
	}
	
	$total += $v;
	$data[$id] = $v;
}

include template($this_module, 'mood');
exit;

}else if(REQUEST_METHOD == 'POST'){

$iid = isset($_POST['iid']) ? intval($_POST['iid']) : 0;
$iid or exit();

$mid = isset($_POST['mid']) ? intval($_POST['mid']) : 0;
$iid or exit();

$data = $DB_slave->fetch_one("SELECT iid FROM {$this_module->TABLE_}mood_data WHERE iid = '$iid'");
if($data){
	$DB_master->update(
		$this_module->TABLE_ .'mood_data',
		array('m'. $mid => 'm'. $mid .' +1'),
		"iid = '$iid'",
		false
	);
}else{
	$DB_master->insert(
		$this_module->TABLE_ .'mood_data',
		array(
			'iid' => $iid,
			'm'. $mid => 1
		)
	);
}

header('Location: '. HTTP_REFERER);
exit;

}