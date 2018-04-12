<?php
defined('PHP168_PATH') or die();

//P8_Member::delete($data, $from_api = false)
	$query = $this->DB_master->query("SELECT $this->table.id, is_founder, $this->table.username FROM $this->table WHERE $data[where]");
	$ids = $comma = '';
	while($arr = $this->DB_master->fetch_array($query)){
		//��ʼ�˲���ɾ��
		if($arr['is_founder']) continue;

		$ids .= $comma . $arr['id'];
		$comma = ',';
		
		//��memcache��ɾ��
		if($this->core->CACHE->memcache){
			$this->core->CACHE->memcache_delete('member_'. $arr['username']);
		}
	}

	if(empty($ids)) return 0;

	$status = true;
	if(($inte = &$this->core->integrate()) && !$from_api){
		//����
		
		$status = $inte->delete_member($ids);
	}
	
	if($status){
		if($ids && $status = $this->DB_master->delete($this->table, "id IN ($ids)")){
			//ɾ������ϵͳ�Ļ�Ա��
			foreach($this->core->systems as $system => $v){
				if(!$v['installed']) continue;
				
				$s = get_system($system);
				$this->DB_master->delete($s['table_prefix'] .'member', "id IN ($ids)");
			}
			
			//ɾ���Ự
			delete_session('uid IN (\''. $ids .'\')');
			
			//ɾ����ֵ��¼
			$this->DB_master->delete($this->TABLE_ .'recharge', "uid IN ($ids)");
			
			//ɾ�����ֱ�
			$this->DB_master->delete($this->core->TABLE_ .'credit_member', "id IN ($ids)");
			
			//ɾ��SESSION
			$this->DB_master->delete($this->core->TABLE_ .'session', "uid IN ($ids)");
			
			//����,����
			$this->DB_master->delete($this->friend_table, "uid IN ($ids)");
			$this->DB_master->delete($this->friend_category_table, "uid IN ($ids)");
			
			//ɾ���ҹ�ģ�������
			$this->delete_hook_module_item($ids);
		}

		return $status;
	}

	return false;