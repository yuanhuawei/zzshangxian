<?php
defined('PHP168_PATH') or die();

//P8_CMS_Category::merge($ids, $to_id)
	
	$this->get_cache();
	
	//Ҫ�Ƶ����಻����
	if(!isset($this->categories[$to_id])) return false;
	
	$ids = (array)$ids;
	$_ids = $comma = '';
	
	foreach($ids as $id){
		//����� || ���಻���� || ���ӷ��� || ��Ŀģ�Ͳ�ͬ
		if(
			!isset($this->categories[$id]) ||
			$this->categories[$id]['type'] == 1 ||
			isset($this->categories[$id]['categories']) ||
			$this->categories[$id]['model'] != $this->categories[$to_id]['model']
		) continue;
		
		$_ids .= $comma . $id;
		$comma = ',';
	}
	
	if(!$_ids) return false;
	
	$model = $this->categories[$to_id]['model'];
	
	$query = $this->DB_master->query("SELECT id, parent, model, item_count, path, html_list_url_rule, htmlize FROM $this->table WHERE id IN ($_ids)");
	
	$count = 0;
	while($arr = $this->DB_master->fetch_array($query)){
		//�޸ĵ�ǰ�����������
		$this->update_count($arr['id'], -$arr['item_count']);
		
		$count += $arr['item_count'];
		
		/*
		//ɾ��HTML�ļ�,�����ļ���һ��ɾ
		$arr['is_category'] = true;
		$file = p8_html_url($item, $arr, 'list', false);
		if($file){
			$path = dirname($file) .'/';
			rm($path);
		}
		*/
	}
	
	$item = &$this->system->load_module('item');
	
	//����
	$this->DB_master->update(
		$this->system->item_table,
		array('cid' => $to_id),
		"cid IN ($_ids)"
	);
	
	//ģ�ͱ�
	$item->set_model($model);
	$this->DB_master->update(
		$item->table,
		array('cid' => $to_id),
		"cid IN ($_ids)"
	);
	
	$aids = $comma = '';
	foreach($item->attributes as $aid => $v){
		$aids .= $comma . $aid;
		$comma = ',';
	}
	
	//���Ա�
	$this->DB_master->update(
		$this->system->TABLE_ .'item_attribute',
		array('cid' => $to_id),
		"aid IN ($aids) AND cid IN ($_ids)"
	);
	
	//Ŀ������������
	$this->update_count($to_id, $count);
	
	
	
	if(false){
		$this->DB_master->delete($this->table, "id IN ($_ids)");
	}