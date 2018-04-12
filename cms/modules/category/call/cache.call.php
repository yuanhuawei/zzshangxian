<?php
defined('PHP168_PATH') or die();

//P8_CMS_Category::cache($cache_all = true, $list_cache = true, $ids = array())
	
	$list = $this->DB_master->query("SELECT * FROM $this->table ORDER BY display_order DESC");
	
	$this->categories = $this->top_categories = array();
	$_top_categories = $_categories = array();
	
	$item = $this->system->load_module('item');
	//生成列表缓存不需要的数据
	$list_unsets = array('item_count', 'page_size', 'html_list_url_rule', 'html_list_url_rule_mobile','list_template', 'view_template', 'item_template', 'list_template_mobile', 'view_template_mobile', 'item_template_mobile', 'display_order', 'seo_keywords', 'seo_description', 'label_postfix', 'config', 'parents', 'CONFIG');
	
	while($arr = $this->DB_master->fetch_array($list)){
		$model = $this->system->get_model($arr['model']);
		if(!empty($model['filterable_fields'])){
			//有自定义过滤字段的不可以静态,但可以访问动态,即使关闭了动态
			$arr['htmlize'] = 0;
			$arr['allow_dynamic'] = 1;
		}
		$arr['frame'] && $arr['frame'] = attachment_url($arr['frame']);
		
		$this->categories[$arr['id']] = $arr;
		$this->categories[$arr['id']]['CONFIG'] = mb_unserialize($arr['config']);
		unset($this->categories[$arr['id']]['config']);
		
		if($list_cache){
			$_categories[$arr['id']] = array(
				'id' => (int)$arr['id'],
				'parent' => (int)$arr['parent'],
				'type' => $arr['type'],
				'name' => $arr['name'],
				'model' => $arr['model']
			);
		}
	}
	
	$path = array();
	
	foreach($this->categories as $v){
		$this->categories[$v['id']]['parents'] = array();
		$this->categories[$v['id']]['id'] = (int)$this->categories[$v['id']]['id'];
		$this->categories[$v['id']]['parent'] = (int)$this->categories[$v['id']]['parent'];
		$this->categories[$v['id']]['enable_show'] = $this->categories[$v['id']]['CONFIG']['enable_show'] && !empty($this->categories[$v['id']]['CONFIG']['enable_show']) ? 1 : 0;
		if($v['parent']){
			
			if(empty($this->categories[$v['parent']])){
				//父分类丢失,转成一级分类
				$this->categories[$v['id']]['parent'] = 0;
				//$this->categories[$v['id']]['path'] = basename($this->categories[$v['id']]['path']);
				$this->DB_master->update($this->table, array('parent' => 0), "id = $v[id]");
				
				$path[$v['id']] = array($v['id']);
				$this->top_categories[$v['id']] = &$this->categories[$v['id']];
				
				$_top_categories[$v['id']] = &$_categories[$v['id']];
			}else{
				
				$this->categories[$v['parent']]['categories'][$v['id']] = &$this->categories[$v['id']];
				
				$_categories[$v['parent']]['categories'][$v['id']] = &$_categories[$v['id']];
			}
			
		}else{
			$path[$v['id']] = array($v['id']);
			$this->top_categories[$v['id']] = &$this->categories[$v['id']];
			
			$_top_categories[$v['id']] = &$_categories[$v['id']];
		}
		
		
		
		
		
		//父分类路径
		$parents = $this->get_parents($v['id']);
		$tmp = $domains = array();
		$domain_flag = empty($v['domain']);
		$paths = '';
		
		foreach($parents as $p){
			$tmp[] = $p['id'];
			$this->categories[$v['id']]['parents'][] = $p['id'];
			
			if($domain_flag && !empty($this->categories[$p['id']]['domain'])){
				$domains[$p['id']] = $this->categories[$p['id']]['domain'];
			}else if(!empty($this->categories[$p['id']]['path'])){
				$paths .= basename($this->categories[$p['id']]['path']) .'/';
			}
		}
		$tmp[] = $v['id'];
		$path[$v['id']] = $tmp;
		
		if(!empty($v['htmlize']) && $v['htmlize'] != 2){
			$paths .= basename($v['path']);
			$this->categories[$v['id']]['path'] = $paths;
		}
		
		//以最近一个分类绑定的域名为主,子类继承父类的域名
		if($domains){
			end($domains);
			$id = key($domains);
			$this->categories[$v['id']]['domain'] = current($domains) .'/'. $paths;
		}
		
		if(empty($this->categories[$v['id']]['url'])){
			//根据分类情况取得绝对地址URL
			$this->categories[$v['id']]['is_category'] = true;
			$this->categories[$v['id']]['url'] = p8_url($item, $this->categories[$v['id']], 'list');
			unset($this->categories[$v['id']]['is_category']);
		}
		
		if($this->categories[$v['id']]['type']==3)
				$this->categories[$v['id']]['target'] = isset($this->categories[$v['id']]['CONFIG']['target'])?$this->categories[$v['id']]['CONFIG']['target']:'_blank';
		
		//各个分类缓存
		if($cache_all || isset($ids[$v['id']])){
			$tmp = $this->categories[$v['id']]; unset($tmp['categories']);
			$tmp['path'] = $v['path'];
			$this->core->CACHE->write($this->system->name .'/modules/', $this->name, (int)$v['id'], $tmp, 'serialize');
		}
		
		if($list_cache){
			foreach($list_unsets as $k){
				unset($this->categories[$v['id']][$k]);
			}
			
			if(empty($this->categories[$v['id']]['htmlize'])){
				unset(
					$this->categories[$v['id']]['htmlize'],
					$this->categories[$v['id']]['list_htmlize'],
					$this->categories[$v['id']]['view_htmlize'],
					$this->categories[$v['id']]['html_view_url_rule'],
					$this->categories[$v['id']]['path'],
					$this->categories[$v['id']]['domain']
				);
			}
			
			if(!empty($this->categories[$v['id']]['domain'])){
				unset($this->categories[$v['id']]['path']);
			}else{
				unset($this->categories[$v['id']]['domain']);
			}
		}
	}
	
	$this->data = array(
		'categories' => &$this->categories,
		'top_categories' => &$this->top_categories,
	);
	
	if($list_cache){
		$this->core->CACHE->write($this->system->name .'/modules/', $this->name, 'categories', $this->data, 'serialize');
		
		$json = array('json' => p8_json($this->make_json_sort($_top_categories)));
		$json['path'] = p8_json($path);
		$this->core->CACHE->write($this->system->name .'/modules/', $this->name, 'json', $json);
		
		unset($json, $_top_categories, $path);
	}