<?php
defined('PHP168_PATH') or die();

//P8_Member::delete($data, $from_api = false)
	$query = $this->DB_master->query("SELECT $this->table.id, is_founder, $this->table.username FROM $this->table WHERE $data[where]");
	$ids = $comma = '';
	while($arr = $this->DB_master->fetch_array($query)){
		//创始人不能删除
		if($arr['is_founder']) continue;

		$ids .= $comma . $arr['id'];
		$comma = ',';
		
		//从memcache中删除
		if($this->core->CACHE->memcache){
			$this->core->CACHE->memcache_delete('member_'. $arr['username']);
		}
	}

	if(empty($ids)) return 0;

	$status = true;
	if(($inte = &$this->core->integrate()) && !$from_api){
		//整合
		
		$status = $inte->delete_member($ids);
	}
	
	if($status){
		if($ids && $status = $this->DB_master->delete($this->table, "id IN ($ids)")){
			//删除其他系统的会员表
			foreach($this->core->systems as $system => $v){
				if(!$v['installed']) continue;
				
				$s = get_system($system);
				$this->DB_master->delete($s['table_prefix'] .'member', "id IN ($ids)");
			}
			
			//删除会话
			delete_session('uid IN (\''. $ids .'\')');
			
			//删除充值记录
			$this->DB_master->delete($this->TABLE_ .'recharge', "uid IN ($ids)");
			
			//删除积分表
			$this->DB_master->delete($this->core->TABLE_ .'credit_member', "id IN ($ids)");
			
			//删除SESSION
			$this->DB_master->delete($this->core->TABLE_ .'session', "uid IN ($ids)");
			
			//好友,分组
			$this->DB_master->delete($this->friend_table, "uid IN ($ids)");
			$this->DB_master->delete($this->friend_category_table, "uid IN ($ids)");
			
			//删除挂钩模块的数据
			$this->delete_hook_module_item($ids);
		}

		return $status;
	}

	return false;