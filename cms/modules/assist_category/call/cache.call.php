<?php
defined('PHP168_PATH') or die();

//P8_CMS_Category::cache($cache_all = true, $write_cache = true, $id = array())
	global $CACHE;
	
	$list = $this->DB_master->query("SELECT * FROM $this->sort_table ORDER BY display_order DESC");
	$this->categories = array();
	$this->top_categories = array();
	$_top_categories = array();
	$_categories = array();
	$datas = array();
	
	$item = $this->system->load_module('item');
	
	while($arr = $this->DB_master->fetch_array($list)){
		
		if(empty($arr['url'])){
			//根据分类情况取得绝对地址URL
			$arr['is_category'] = true;
			$arr['url'] = p8_url($this, $arr, 'list');
			unset($arr['is_category']);
		}
		
		$this->categories[$arr['id']] = $arr;
		
		if($write_cache){
			$_categories[$arr['id']] = $this->categories[$arr['id']] = array(
				'id' => (int)$arr['id'],
				'parent' => (int)$arr['parent'],
				'type' => $arr['type'],
				'name' => $arr['name'],
				'item_count' => $arr['item_count'],
				'display_order'=>$arr['display_order']
			);
		}
		
		$datas[$arr['id']] = $arr;
	}
	
	foreach($this->categories as $v){
		if($v['parent']){
			if($write_cache){
				$this->categories[$v['parent']]['categories'][] = &$this->categories[$v['id']];
			}else{
				$this->categories[$v['parent']]['categories'][$v['id']] = &$this->categories[$v['id']];
			}
			
			$_categories[$v['parent']]['categories'][$v['id']] = &$_categories[$v['id']];
		}else{
			if($write_cache){
				$this->top_categories[] = &$this->categories[$v['id']];
			}else{
				$this->top_categories[$v['id']] = &$this->categories[$v['id']];
			}
			
			$_top_categories[$v['id']] = &$_categories[$v['id']];
		}
		
		if($cache_all || isset($id[$v['id']]))
			$CACHE->write($this->system->name .'/modules/', $this->name, (int)$v['id'], $datas[$v['id']]);
	}
	unset($datas);
	
	$this->data = array(
		'categories' => &$this->categories,
		'top_categories' => &$this->top_categories,
	);

	if($write_cache){
		$CACHE->write($this->system->name .'/modules/', $this->name, 'categories', $this->data, 'serialize');
		$json = array('json' => jsonencode($_top_categories));
		
		//菜单路径
		$path = array();
		foreach($this->categories as $v){
			$parents = $this->get_parents($v['id']);
			$tmp = array();
			foreach($parents as $p){
				$tmp[] = $p['id'];
			}
			$tmp[] = $v['id'];
			
			$path[$v['id']] = $tmp;
		}

		$json['path'] = jsonencode($path);
		$CACHE->write($this->system->name .'/modules/', $this->name, 'json', $json);
	}