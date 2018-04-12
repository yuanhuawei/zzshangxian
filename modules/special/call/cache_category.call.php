<?php
defined('PHP168_PATH') or die();

//P8_Special_Category::cache($cache_all = true, $write_cache = true, $id = 0)
	global $CACHE;
	
	$list = $this->sp_mod->DB_master->query("SELECT * FROM $this->table ORDER BY display_order DESC");
	$this->categories = array();
	$this->top_categories = array();
	$_top_categories = array();
	$_categories = array();
	$datas = array();
	
	while($arr = $this->sp_mod->DB_master->fetch_array($list)){
		
		if(empty($arr['url'])){
			//根据分类情况取得绝对地址URL
			$arr['is_category'] = true;
			$arr['url'] = p8_url($this->sp_mod, $arr, 'list');
			unset($arr['is_category']);
		}
		
		$this->categories[$arr['id']] = $arr;
		
		if($write_cache){
			$_categories[$arr['id']] =$this->categories[$arr['id']]= array(
				'htmlize' => $this->sp_mod->CONFIG['htmlize'],
				'id' => (int)$arr['id'],
				'parent' => (int)$arr['parent'],
				'type' => $arr['type'],
				'name' => $arr['name'],
				'item_count' => $arr['item_count'],
				'page_size' => 20,
				'html_list_url_rule' => $this->sp_mod->CONFIG['html_list_url_rule'],
				'html_view_url_rule' => $this->sp_mod->CONFIG['html_view_url_rule'],
				'url' => $arr['url']
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
		
		if($cache_all || $id == $v['id'])
			$CACHE->write(
				$this->sp_mod->system->name .'/modules/'. $this->sp_mod->name .'/category',
				$this->sp_mod->name,
				(int)$v['id'],
				$datas[$v['id']]
			);
	}
	unset($datas);
	
	$this->data = array(
		'categories' => &$this->categories,
		'top_categories' => &$this->top_categories,
	);
	if($write_cache){
		$CACHE->write(
			$this->sp_mod->system->name .'/modules/',
			$this->sp_mod->name,
			'categories',
			$this->data,
			'serialize'
		);
		
		$json = array(
			'json' => jsonencode($_top_categories)
		);
		
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
		
		$CACHE->write(
			$this->sp_mod->system->name .'/modules/',
			$this->sp_mod->name,
			'category_json',
			$json
		);
	}