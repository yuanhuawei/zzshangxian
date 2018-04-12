<?php
defined('PHP168_PATH') or die();

//P8_CMS_Category::merge($ids, $to_id)
	
	$this->get_cache();
	
	//要移到分类不存在
	if(!isset($this->categories[$to_id])) return false;
	
	$ids = (array)$ids;
	$_ids = $comma = '';
	
	foreach($ids as $id){
		//大分类 || 分类不存在 || 有子分类 || 栏目模型不同
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
		//修改当前分类的内容数
		$this->update_count($arr['id'], -$arr['item_count']);
		
		$count += $arr['item_count'];
		
		/*
		//删除HTML文件,整个文件夹一起删
		$arr['is_category'] = true;
		$file = p8_html_url($item, $arr, 'list', false);
		if($file){
			$path = dirname($file) .'/';
			rm($path);
		}
		*/
	}
	
	$item = &$this->system->load_module('item');
	
	//主表
	$this->DB_master->update(
		$this->system->item_table,
		array('cid' => $to_id),
		"cid IN ($_ids)"
	);
	
	//模型表
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
	
	//属性表
	$this->DB_master->update(
		$this->system->TABLE_ .'item_attribute',
		array('cid' => $to_id),
		"aid IN ($aids) AND cid IN ($_ids)"
	);
	
	//目标分类的内容数
	$this->update_count($to_id, $count);
	
	
	
	if(false){
		$this->DB_master->delete($this->table, "id IN ($_ids)");
	}