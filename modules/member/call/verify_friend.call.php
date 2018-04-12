<?php
defined('PHP168_PATH') or die();

//P8_Member::verify_friend($fuid, $value = 1, $reason = ''){

	$fuid = (array)$fuid;
	$ids = implode(',', $fuid);
	if(empty($ids)) return false;
	
	global $UID, $P8LANG, $USERNAME;
	
	$query = $this->DB_slave->query("SELECT fuid, cid FROM $this->unverified_friend_table WHERE uid = '$UID' AND fuid IN ($ids)");
	$ids = $comma = '';
	$f = array();
	while($arr = $this->DB_slave->fetch_array($query)){
		$ids .= $comma . $arr['fuid'];
		$f[$arr['fuid']] = $arr['cid'];
	}
	if(empty($f)) return false;
	
	if(
		$this->DB_master->delete(
			$this->unverified_friend_table,
			"uid = '$UID' AND fuid IN ($ids)"
		)
	){
		$message = &$this->core->load_module('message');
		
		$m = array(
			'uid' => array_keys($f),
			'title' => p8lang($P8LANG['verified_to_be_friends'], $USERNAME),
			'content' => p8lang($P8LANG['verified_to_be_friends'], $USERNAME),
			'system' => true
		);
		
		$message->send($m);
		
		foreach($f as $fuid => $cid){
			$this->add_friend($fuid, $cid, '', true);
		}
		
	}