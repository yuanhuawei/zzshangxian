<?php
defined('PHP168_PATH') or die();

//P8_Member::add_friend($fuid, $cid = 0, $description = '', $verified = false)
	global $UID, $P8LANG, $USERNAME;
	
	if($fuid == $UID) return 0;
	
	if($verified){
		//允许任何人加好友
		$this->DB_master->insert(
			$this->friend_table,
			array(
				'uid' => $UID,
				'fuid' => $fuid,
				'cid' => $cid,
				'timestamp' => P8_TIME,
				'description' => $description
			)
		);
		
		
		$this->DB_master->insert(
			$this->friend_table,
			array(
				'uid' => $fuid,
				'fuid' => $UID,
				'cid' => 0,
				'timestamp' => P8_TIME,
				'description' => ''
			)
		);
		
		//发送消息
		$m = array(
			'uid' => $fuid,
			'title' => p8lang($P8LANG['to_be_your_friend'], $USERNAME),
			'content' => p8lang($P8LANG['to_be_your_friend'], $USERNAME),
			'system' => true
		);
		
		$message = &$this->core->load_module('message');
		$message->send($m);
		
		//分类的好友数
		$this->update_friend_category_count($cid, 1);
		
		return 1;
		
	}else{
		
		//需要验证
		
		$this->DB_master->insert(
			$this->unverified_friend_table,
			array(
				'uid' => $fuid,
				'fuid' => $UID,
				'cid' => $cid,
				'timestamp' => P8_TIME,
				'description' => $description
			)
		);
		
		//发送消息
		$m = array(
			'uid' => $fuid,
			'title' => p8lang($P8LANG['request_to_be_friends'], $USERNAME),
			'content' => p8lang($P8LANG['request_to_be_friends_content'], $USERNAME, $description),
			'system' => true
		);
		
		$message = &$this->core->load_module('message');
		$message->send($m);
		
		return -4;
	}