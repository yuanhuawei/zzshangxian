<?php
defined('PHP168_PATH') or die();

//P8_Member::delete_friend($fuid, $verified = true)
	
	$fuid = (array)$fuid;
	$ids = implode(',', $fuid);
	if(empty($ids)) return false;
	
	global $UID;
	
	$T = $verified ? $this->friend_table : $this->unverified_friend_table;
	
	$query = $this->DB_slave->query("SELECT cid, uid, fuid FROM $T WHERE uid = '$UID' AND fuid IN ($ids) OR fuid = '$UID' AND uid IN ($ids)");
	$fuid = $count = $count2 = array();
	$ids = $comma = '';
	while($arr = $this->DB_slave->fetch_array($query)){
		$ids .= $comma . $arr['fuid'];
		$comma = ',';
		$fuid[] = $arr['fuid'];
		
		if($verified){
			if($arr['uid'] == $UID){
				$count[$arr['cid']] = isset($count[$arr['cid']]) ? $count[$arr['cid']] +1 : 1;
			}else{
				$count2[$arr['cid']] = isset($count2[$arr['cid']]) ? $count2[$arr['cid']] +1 : 1;
			}
		}
	}
	
	if(
		$ids && $this->DB_master->delete(
			$T,
			"uid = '$UID' AND fuid IN ($ids) OR fuid = '$UID' AND uid IN ($ids)"
		)
	){
		if($verified){
			//减少被删除分类的好友数
			foreach($count as $cid => $v){
				$this->update_friend_category_count($cid, -$v);
			}
			
			foreach($count2 as $cid => $v){
				$this->update_friend_category_count($cid, -$v);
			}
		}
	}