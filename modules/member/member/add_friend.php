<?php
defined('PHP168_PATH') or die();

/**
* ��Ӻ���,ֻ�ṩAJAX
* 1 => �ɹ�, -1 => �û�������, -2 => ���Ѽ�����, -3 => �ȴ���֤, -4 => ��֤��, -5 => �û��ܾ�, 0 => ʧ��
**/

//if(REQUEST_METHOD == 'POST'){
	
	//load_language($this_module, 'friend');
	
	$test = isset($_GET['test']) ? true : false;
	$fuid = isset($_GET['fuid']) ? intval($_GET['fuid']) : 0;
	$fuid or exit('0');
	if($fuid == $UID) exit('0');
	
	$check = $DB_slave->fetch_one("SELECT m.id, m.friend_setting, f.fuid, uf.fuid AS ufuid FROM $this_module->table AS m
		LEFT JOIN $this_module->friend_table AS f ON f.uid = m.id AND f.fuid = '$UID'
		LEFT JOIN $this_module->unverified_friend_table AS uf ON uf.uid = m.id AND uf.fuid = '$UID'
		WHERE m.id = '$fuid'");
	
	if(empty($check['id'])) exit('-1');
	if($check['fuid']) exit('-2');
	
	$cid = isset($_GET['cid']) ? intval($_GET['cid']) : 0;
	$description = isset($_GET['description']) ? filter_word(html_entities(from_utf8($_GET['description']))) : '';
	
	if($check['ufuid']) exit('-4');
	if($check['friend_setting'] == 1 && !strlen($description)) exit('-3');
	
	if($check['friend_setting'] == 2) exit('-5');
	if($test) exit('1');
	
	exit((string) $this_module->add_friend($fuid, $cid, $description, $check['friend_setting'] == 0 ? true : false));
//}