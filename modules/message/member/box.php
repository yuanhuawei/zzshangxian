<?php
defined('PHP168_PATH') or die();

/**
 * 短消息提示框
 */

if(REQUEST_METHOD == 'GET'){
	$json = $DB_slave->fetch_one("SELECT id, sender_uid, title, content, username, COUNT(*) AS `new_count` FROM $this_module->table WHERE sendee_uid = '$UID' AND type = 'in' AND new = '1' ORDER BY timestamp DESC LIMIT 1");
	
	$json['title'] = p8_cutstr($json['title'], 30);
	$json['content'] = p8_cutstr($json['title'], 80);
	$json['username'] || $json['username'] = $P8LANG['system_message'];
	$json['url'] = $this_router .'-read?type=in&id='. $json['id'];
	
	exit(p8_json($json));
}else{
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	
	$DB_master->update($this_module->table, array('type' => 'rubbish'), "sendee_uid = '$UID' AND id = '$id'");
	
	exit(p8_json(array('id' => $id, 'move' => true)));
}