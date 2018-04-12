<?php
defined('PHP168_PATH') or die();

//P8_Member::update($id, &$data, &$orig_data){
	
	$attachment_hash = $data['attachment_hash'];
	unset($data['attachment_hash']);
	
	if(isset($data['password']) && strlen($data['password'])){
		global $IS_FOUNDER;
		if($orig_data['is_founder'] && !$IS_FOUNDER){
			//如果被修改的用户是创始人而当前用户不是创始人
		}else{
			$this->change_password($orig_data['username'], $data['password']);
		}
	}
	unset($data['password']);
	
	if(isset($data['#data#'])){
		//自定义字段
		$field_data = $data['#data#'];
		unset($data['#data#']);
		
		$this->DB_master->update(
			$this->addon_table,
			$field_data,
			"id = '$id'"
		);
	}

	$status = $this->DB_master->update(
		$this->table,
		$data,
		"id = '$id'"
	);
	
	if(isset($data['role_gid']) && $orig_data['role_gid'] != $data['role_gid']){
		//如果角色组有改变
		$this->set_model($orig_data['role_gid']);
		$this->DB_master->delete($this->addon_table, "id = '$id'");
		
		$this->set_model($data['role_gid']);
		$this->DB_master->insert($this->addon_table, array('id' => $id));
		
	}
	
	if(isset($data['role_id']) && $orig_data['role_id'] != $data['role_id']){
		$this->set_role($id, $data['role_id'], $orig_data['username']);
	}
	
	//会员状态有改变
	if(isset($data['status']) && $orig_data['status'] != $data['status']){
		//删掉SESSION
		
		delete_session('uid = \''. $id .'\'');
	}
	
	uploaded_attachments($this, $id, $attachment_hash);
	
	if($this->core->CACHE->memcache){
		$data = $this->DB_master->fetch_one("SELECT * FROM $this->table AS m INNER JOIN $this->addon_table as a ON m.id = a.id WHERE m.id = '$id'");
		
		get_member($data['username'], true);
	}
	
	return true;