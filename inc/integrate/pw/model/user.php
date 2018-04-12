<?php

class usermodel {

	var $base;
	var $db;
	var $db_pre;
	var $user;

	function __construct(&$base) {
		$this->usermodel($base);
	}

	function usermodel(&$base) {
		$this->base =& $base;
		$this->db =& $base->db;
		$this->db_pre =& $base->db_pre;
	}

	function get_by_uid($uid) {
		$arr = $this->db->get_one("SELECT uid,username,password,safecv,email,regdate FROM ".$this->db_pre."members WHERE uid=" . UC::escape($uid));
		return $arr;
	}

	function get_by_username($username) {
		$arr = $this->db->get_one("SELECT uid,username,password,safecv,email,regdate FROM ".$this->db_pre."members WHERE username=" . UC::escape($username));
		return $arr;
	}

	function get_by_email($email, $unique = true) {
		$query = $this->db->query("SELECT uid,username,password,safecv,email,regdate FROM ".$this->db_pre."members WHERE email=" . UC::escape($email));
		$num = $this->db->num_rows($query);
		if ($unique) {
			$arr = $this->db->fetch_array($query);
		} else {
			$arr = array();
			while ($rt = $this->db->fetch_array($query)) {
				$arr[] = $rt;
			}
		}
		return array($arr, $num);
	}

	function check_email($email,$username) {
		$ucsql = $username ? " AND username<>" . UC::escape($username) : '';
		$count = $this->db->get_value("SELECT COUNT(*) AS sum FROM ".$this->db_pre."members WHERE email=" . UC::escape($email) . $ucsql);
		return $count;
	}
	
	//xu @10:33 2010-8-19
	function add($username, $pwd, $email) {
		$mainFields = array(
			'username'	=> $username,
			'password'	=> $pwd,
			'email'		=> $email,
			'groupid'	=> 0,
			'regdate'	=> $this->base->time
		);
		
		$uid = $this->base->insertTable('members',$mainFields,1);
		if($uid) {
			$memberDataFields = array(
				'uid' => $uid,
				'lastvisit'	=> $this->base->time,
				'thisvisit'	=> $this->base->time,
				'onlineip'	=> $this->base->onlineip
			);
			$this->base->insertTable('memberdata',$memberDataFields);
		} else {
			$uid = 0;
		}
		return $uid;
	}

	function delete($uids) {
		if ($uids) {
			if(is_array($uids)) $uids = UC::implode($uids);
			$this->db->update('DELETE FROM '.$this->db_pre."members WHERE uid IN (" .$uids. ')');
			$this->db->update('DELETE FROM '.$this->db_pre."memberdata WHERE uid IN (" .$uids. ')');
			return $this->db->affected_rows();
		}
		return 0;
	}

	function edit($uid, $username, $pwd, $email) {
		$user  = $this->get_by_uid($uid);
		$ucsql = array();
		$retv  = 0;
		if ($username && $user['username'] != $username) {
			$ucsql[] = "`username`='$username'";
			$retv++;
		}
		//这里的pwd已经md5过了。
		if ($pwd && $user['password'] != $pwd) {
			$ucsql[] = "`password`='$pwd'";
		}
		if ($email && $user['email'] != $email) {
			$ucsql[] = "`email`='$email'";
		}
		if ($ucsql) {
			$retv++;
			$sql = "UPDATE ".$this->db_pre."members SET ".implode(',',$ucsql)." WHERE uid=$uid";
			$this->db->update($sql);
		}
		return $retv;
	}
}