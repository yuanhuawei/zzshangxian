<?php
defined('PHP168_PATH') or die();

//P8_Member::register($username, $password, $email, $datas = array()){
	
	//�����id,��˵���Ǵӱ���ķ������ù�����,����Ҫ���õ�ע��,Ҫ��id���
	if(($inte = &$this->core->integrate()) && empty($datas['id'])){
		
		//��û���û�
		$status = $inte->register($username, $password, $email);
		
		if($status < 1)
			return $status;
		
		$data = $datas;
		$data['id'] = $status;
		
		//���뱾ϵͳ
		$data['role_id'] = empty($datas['role_id']) ? $this->core->CONFIG['member_role'] : $datas['role_id'];
		$this->core->get_cache('role');
		//��ɫ��
		$data['role_gid'] = $this->core->roles[$data['role_id']]['gid'];
		
		return $this->register($username, $password, $email, $data);

		//�û��Ѿ�����
		return -2;

	}else{
		
		//������ֵ,���û���������������һ��
		$salt = isset($datas['salt']) ? $datas['salt'] : rand_str(4);
		$_password = isset($datas['password']) ? $datas['password'] : $password;

		//�����ϵĲ���
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
		//�Ƿ�ͬ������ID
		if(!empty($datas['id']))
		$data['id'] = $datas['id'];

		$id = $this->DB_master->insert($this->table, $data, array('return_id' => true));
		
		if($id){
			//���ֱ�
			$this->DB_master->insert(
				$this->core->TABLE_ .'credit_member',
				array('id' => $id)
			);
			
			//�Զ����ɫ���ֶ�
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