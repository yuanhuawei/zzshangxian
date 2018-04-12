<?php
defined('PHP168_PATH') or die();

//P8_CMS_Category::update($id, &$data, &$orig_data)
	$this->get_cache();
	$ids = $this->get_children_ids($id) + array($id);
	//���ܰѸ������ƶ������ӷ���ȥ
	if(in_array($data['parent'], $ids)) return false;
	unset($data['auto_label_postfix']);
	$status = $this->DB_master->update(
		$this->table,
		$data,
		"id = '$id'"
	);
	//��������������¾��޹ؽ�Ҫ��
	if($data['type'] == 3){
		$this->cache(false, true, $ids);
	
		return $status;
	}
	if($data['parent'] != $this->categories[$id]['parent']){
		//�ƶ�������
		
		//$orig_data = $this->DB_master->fetch_one("SELECT item_count FROM $this->table WHERE id = '$id'");
		
		//�Ƶ��ķ������Ӽ�¼��
		$this->update_count($data['parent'], $orig_data['item_count']);
		
		//���ƶ��ļ��ټ�¼��
		$this->update_count($this->categories[$id]['parent'], -$orig_data['item_count']);
	}
	
	$ids = array($id => 1);
	
	//�޸��˾�̬������
	if(
		isset($data['htmlize']) && !empty($_POST['htmlize_apply_category'])
	){
		
		$htmlize = $data['htmlize'];
		$cids = $this->get_children_ids($id);
		
		//���������ӷ���ľ�̬������
		if(!empty($cids)){
			$this->DB_master->update(
				$this->table,
				array('htmlize' => $htmlize),
				'id IN ('. implode(',', $cids) .')'
			);
			
			$ids = $ids + array_flip($cids);
		}
		
	}
	
	//�޸���HTML·��
	if(isset($data['path']) && $orig_data['path'] != $data['path']){
		$cids = $this->get_children_ids($id);
		
		//֪ͨ�����ӷ������·��
		foreach($cids as $v){
			$d = $this->DB_master->fetch_one("SELECT path FROM $this->table WHERE id = '$v'");
			
			$this->DB_master->update(
				$this->table,
				array('path' => preg_replace('|^'. $orig_data['path'] .'/|', $data['path'] .'/', $d['path'])),
				"id = '$v'"
			);
		}
		
		$ids = $ids + array_flip($cids);
		
		//����
		@rename($this->system->path . $orig_data['path'], $this->system->path . $data['path']);
	}
	
	//URL����
	if(
		($cids = $this->get_children_ids($id)) &&
		(!empty($_POST['list_rule_apply_category']) || !empty($_POST['view_rule_apply_category']))
	){
		$rule = array();
		
		if(!empty($_POST['list_rule_apply_category'])){
			$rule['html_list_url_rule'] = $data['html_list_url_rule'];
			$rule['html_list_url_rule_mobile'] = $data['html_list_url_rule_mobile'];
		}
		if(!empty($_POST['view_rule_apply_category'])){
			$rule['html_view_url_rule'] = $data['html_view_url_rule'];
			$rule['html_view_url_rule_mobile'] = $data['html_view_url_rule_mobile'];
		}
		
		$this->DB_master->update(
			$this->table,
			$rule,
			'id IN ('. implode(',', $cids) .')'
		);
		
		$ids = $ids + array_flip($cids);
	}
	
	$this->cache(false, true, $ids);
	
	return $status;