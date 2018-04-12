<?php
defined('PHP168_PATH') or die();

//P8_CMS_Category::delete($data)
	global $CACHE;
	
	$query = $this->DB_master->query("SELECT id, model FROM $this->table WHERE $data[where]");
	$id = array();
	$this->get_cache();
	while($arr = $this->DB_master->fetch_array($query)){
		$id[] = $arr['id'];
		//��ͬ�ӷ���һ��ɾ��
		$cids = $this->get_children_ids($arr['id']);
		$id = array_merge($id, $cids);
	}
	
	$ids = implode(',', $id);
	
	$status = 0;
	if($ids && $status = $this->DB_master->delete($this->table, "id IN ($ids)")){
		
		$item = &$this->system->load_module('item');
		
		//���Ȩ��
		//ɾ����Ӧ��ʾ��ı�ǩ
		$role = &$this->core->load_module('role');
		foreach($id as $i){
			$role->delete_acl(
				array(
					'system' => $this->system->name,
					'module' => $item->name,
					'postfix' => 'category_'. $i
				)
			);
			
			$this->DB_master->delete(
				$this->core->TABLE_ .'label',
				"system = '{$this->system->name}' AND module = '{$item->name}' AND postfix = 'category_$i'"
			);
			
			//ɾ������
			$CACHE->delete($this->system->name .'/modules', $this->name, (int)$i);
		}
		
		//ɾ������ģ������
		if(!empty($data['delete_hook']) || !empty($data['hook'])){
			$this->delete_hook_module_item($ids);
		}
	}
	
	return $status ? $id : array();