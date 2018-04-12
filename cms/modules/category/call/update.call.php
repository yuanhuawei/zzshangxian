<?php
defined('PHP168_PATH') or die();

//P8_CMS_Category::update($id, &$data, &$orig_data)
	$this->get_cache();
	$ids = $this->get_children_ids($id) + array($id);
	//不能把父分类移动到其子分类去
	if(in_array($data['parent'], $ids)) return false;
	unset($data['auto_label_postfix']);
	$status = $this->DB_master->update(
		$this->table,
		$data,
		"id = '$id'"
	);
	//如果是外链，以下就无关紧要了
	if($data['type'] == 3){
		$this->cache(false, true, $ids);
	
		return $status;
	}
	if($data['parent'] != $this->categories[$id]['parent']){
		//移动过分类
		
		//$orig_data = $this->DB_master->fetch_one("SELECT item_count FROM $this->table WHERE id = '$id'");
		
		//移到的分类增加记录数
		$this->update_count($data['parent'], $orig_data['item_count']);
		
		//被移动的减少记录数
		$this->update_count($this->categories[$id]['parent'], -$orig_data['item_count']);
	}
	
	$ids = array($id => 1);
	
	//修改了静态化开关
	if(
		isset($data['htmlize']) && !empty($_POST['htmlize_apply_category'])
	){
		
		$htmlize = $data['htmlize'];
		$cids = $this->get_children_ids($id);
		
		//更新所有子分类的静态化设置
		if(!empty($cids)){
			$this->DB_master->update(
				$this->table,
				array('htmlize' => $htmlize),
				'id IN ('. implode(',', $cids) .')'
			);
			
			$ids = $ids + array_flip($cids);
		}
		
	}
	
	//修改了HTML路径
	if(isset($data['path']) && $orig_data['path'] != $data['path']){
		$cids = $this->get_children_ids($id);
		
		//通知所有子分类更新路径
		foreach($cids as $v){
			$d = $this->DB_master->fetch_one("SELECT path FROM $this->table WHERE id = '$v'");
			
			$this->DB_master->update(
				$this->table,
				array('path' => preg_replace('|^'. $orig_data['path'] .'/|', $data['path'] .'/', $d['path'])),
				"id = '$v'"
			);
		}
		
		$ids = $ids + array_flip($cids);
		
		//改名
		@rename($this->system->path . $orig_data['path'], $this->system->path . $data['path']);
	}
	
	//URL规则
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