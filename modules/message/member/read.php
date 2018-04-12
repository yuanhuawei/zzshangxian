<?php
defined('PHP168_PATH') or die();

/**
* 读信息
**/

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$id or message('no_such_item');
$type = isset($_GET['type']) && in_array($_GET['type'], array('in', 'out', 'rubbish'))? $_GET['type'] : '';
if($type == ''){
	message('no_such_item');
}

$select = select();

$select->from($this_module->table .' AS m', 'm.*');
$select->in('m.id', $id);
$select->in(($type == 'in'||$type=='rubbish') ? 'm.sendee_uid' : 'm.sender_uid', $UID);
$select->in('m.type', $type);
$data = $core->select($select, array('single' => true));
$data or message('no_such_item');

if($data['new']){
	//己读
	$DB_master->update(
		$this_module->table,
		array('new' => 0),
		"id = '$id' AND sendee_uid = '$UID' AND type = '$type'"
	);
	
	//减少未读信息数
	$DB_master->update(
		$core->member_table,
		array('new_messages' => 'new_messages -1'),
		"id = '$UID'",
		false
	);
}
if(P8_AJAX_REQUEST){
		exit(p8_json($data));
	}


include template($this_module, 'read');