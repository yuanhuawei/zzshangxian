<?php
defined('PHP168_PATH') or die();

//P8_Member::move_friend($fuid, $cid){
	$fuid = (array)$fuid;
	$ids = implode(',', $fuid);
	if(empty($ids)) return false;
	
	global $UID;
	
	$query = $this->DB_slave->query("SELECT cid FROM $this->friend_table WHERE uid = '$UID' AND fuid IN ($ids)");
	$count = array();
	while($arr = $this->DB_slave->fetch_array($query)){
		$count[$arr['cid']] = isset($count[$arr['cid']]) ? $count[$arr['cid']] +1 : 1;
	}
	
	if(
		$this->DB_master->update(
			$this->friend_table,
			array('cid' => $cid),
			"uid = '$UID' AND fuid IN ($ids)"
		)
	){
		//减少被移动分类的好友数
		foreach($count as $id => $v){
			$this->update_friend_category_count($id, -$v);
		}
		
		//增加新移动分类的好友数
		$this->update_friend_category_count($cid, count($count));
		
		return true;
	}
	
	return false;