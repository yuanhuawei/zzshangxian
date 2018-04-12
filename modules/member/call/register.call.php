<?php
defined('PHP168_PATH') or die();

//P8_Member::register($username, $password, $email, $datas = array()){
	
	//如果有id,则说明是从本类的方法调用过来的,其他要调用的注意,要把id清掉
	if(($inte = &$this->core->integrate()) && empty($datas['id'])){
		
		//还没有用户
		$status = $inte->register($username, $password, $email);
		
		if($status < 1)
			return $status;
		
		$data = $datas;
		$data['id'] = $status;
		
		//插入本系统
		$data['role_id'] = empty($datas['role_id']) ? $this->core->CONFIG['member_role'] : $datas['role_id'];
		$this->core->get_cache('role');
		//角色组
		$data['role_gid'] = $this->core->roles[$data['role_id']]['gid'];
		
		return $this->register($username, $password, $email, $data);

		//用户已经存在
		return -2;

	}else{
		
		//加密盐值,如果没定义有则随机生成一个
		$salt = isset($datas['salt']) ? $datas['salt'] : rand_str(4);
		$_password = isset($datas['password']) ? $datas['password'] : $password;

		//非整合的操作
		$data = array(
			'username' => $username,
			'password' => md5(md5($_password) . $salt),
			'email' => $email,
			'role_id' => empty($datas['role_id']) ? $this->core->CONFIG['member_role'] : $datas['role_id'],
			'role_gid' => empty($datas['role_gid']) ? $this->core->CONFIG['person_role_group'] : $datas['role_gid'],
			'register_time' => P8_TIME,
			'register_ip' => P8_IP,
			'salt' => $salt,
			'status' => isset($datas['status']) ? $datas['status'] : 0,
			'is_founder' => empty($datas['is_founder']) ? 0 : 1,
			'is_admin' => empty($datas['is_admin']) ? 0 : 1,
			'name' => isset($datas['name']) ? $datas['name'] : '',
			'cell_phone' => isset($datas['cell_phone']) ? $datas['cell_phone'] : '',
			'pinyin' => isset($datas['pinyin']) ? $datas['pinyin'] : ''
		);
		if(!empty($datas['number']))$data['number'] = $datas['number'];
		if(!empty($datas['address']))$data['address'] = $datas['address'];
		if(!empty($datas['phone']))$data['phone'] = $datas['phone'];
		if(!empty($datas['cell_phone']))$data['cell_phone'] = $datas['cell_phone'];
		//是否同步整合ID
		if(!empty($datas['id']))
		$data['id'] = $datas['id'];

		$id = $this->DB_master->insert($this->table, $data, array('return_id' => true));
		
		if($id){
			//积分表
			$this->DB_master->insert(
				$this->core->TABLE_ .'credit_member',
				array('id' => $id)
			);
			
			//自定义角色组字段
			$_data = array('id' => $id);
			if(isset($datas['#data#'])) $_data = array_merge($_data, $datas['#data#']);
			$orig_gid = $this->role_gid;
			$this->set_model($data['role_gid']);
			$this->DB_master->insert(
				$this->addon_table,
				$_data
			);
			$this->set_model($orig_gid);
			$this->send_register($data,$id,$_password);
			return $id;
		}

	}

	return -2;