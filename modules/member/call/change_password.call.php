<?php
defined('PHP168_PATH') or die();

//P8_Member::change_password($username, $new, $old = '', $from_api = false){
	$status = true;

	if(($inte = &$this->core->integrate()) && !$from_api){
		//如果不是从API传过来的,并且是整合

		if(($status = $inte->passwd($username, $new, $old)) != 0){
			return -3;
		}

		$status = true;
	}else{
		//如果传入有旧密码
		if(strlen($old)){
			$info = $this->DB_master->fetch_one("SELECT password, salt FROM $this->table WHERE username = '$username'");
			
			if(isset($info['password']) && $info['password'] === md5(md5($old) . $info['salt'])){
				$status = true;
			}else{
				$status = false;
			}
		}
	}

	//产生一个新的盐值
	$new_salt = rand_str(4);
	
	if($this->core->CACHE->memcache){
		$data = $this->DB_master->fetch_one("SELECT * FROM $this->table AS m INNER JOIN $this->addon_table as a ON m.id = a.id WHERE m.id = '$id'");
		
		get_member($data['username'], true);
	}

	return ($status && $this->DB_master->update(
		$this->table,
		array(
			'password' => md5(md5($new) . $new_salt),
			'salt' => $new_salt
		),
		"username = '$username'"
	)) ? 0 : -3;