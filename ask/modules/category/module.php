<?php
class P8_Ask_Category extends P8_module{

	var $categories;		//总分类,外部可以直接传入id $obj->categories[$id] 直接得到相应的分类,无须关心分类属于哪个父分类,并可以直接获得其子分类节点
	var $top_categories;	//顶级分类,仅包含顶级分类,并且有其所有子分类的树形结构数组
	var $data;
	var $table;
	var $table_data;


	function P8_Ask_Category(&$system, $name){
		//本模块没有设置
		$this->configurable = false;
		$this->system = &$system;
		parent::__construct($name);
		
		$this->table = $this->TABLE_;
		$this->table_data = $this->TABLE_ . 'data';
	}

	/**
	 * 检查分类名是否存在
	 * param string $condition 条件
	 * return bool true||false 存在:true,不存在:false
	 */
	function check_exists($condition){

		if($this->DB_master->fetch_one("SELECT id FROM " . $this->table . " WHERE $condition")){
			return true;
		}else{
			return false;
		}

	}
	
	/**
	 * 添加分类
	 * param array &$data 数据
	 * return array $ids 返回添加分类的ID字符串值(形式:1,2,3...)
	 */
	function batch_add(&$data){

		$ids = $comma = '';
		
		foreach($data['names'] as $name){
			$insert_id = $this->DB_master->insert(
				$this->table,
				array(
					'parent' => $data['parent'],
					'name' => $name
				),
				array('return_id' => true)
			);
			
			$ids .= $comma . $insert_id;	
			$comma = ',';
		}

		return $ids;

	}

	/**
	 * 删除分类
	 * @param string $condition 条件
	 * @return int $affected_rows 返回删除数目
	*/
	function delete($data){
		
		$affected_rows = $this->DB_master->delete(
			$this->table,
			$data['where']
		);

		$this->cache();

		return $affected_rows;
		
	}

	/**
	 * 更新分类
	 * param int $id 分类ID
	 * param array &$data 数据
	 */
	function batch_update($id, &$data){

		$this->DB_master->update(
			$this->table,
			$data,
			"id='$id'"
		);

		return $id;

	}

	/**
	 * 更新分类数目
	 * param array &$data 数据
	 * return int 返回影响数目
	*/
	function update_item_count($data){
		$this->cache(false, false);
		//如果有父分类同时更新父分类
		$allids = $data['id'];
		$parents = $this->get_parents($data['id']);
		if($parents){
			foreach($parents as $v){
				$allids .= ',' . $v['id'];
			}
		}

		if($data['mark'] == '-'){
			$update_data = array('item_count' => 'item_count-'.$data['number']);
		}else{
			$update_data = array('item_count' => 'item_count+'.$data['number']);
		}
		$status= $this->DB_master->update(
			$this->table,
			$update_data,
			"id IN ($allids)",
			false
		);
		$this->cache(false, true);
		return $status;
	}

	/**
	 * 生成缓存
	 * param string $model 指定模型,如果不指定则是生成所有模型的分类
	 * param bool $cache_all 是否把每个分类都缓存成一个缓存文件
     * param bool $write_cache 是否写缓存,如果否,则不写缓存,保持树形结构,用于实时刷新
     * param int $id 只缓存的分类的ID
	 */
	function cache($cache_all = true, $write_cache = true, $id = 0){
		parent::cache();
	
		global $CACHE;
		
		$query = $this->DB_master->query("SELECT * FROM $this->table ORDER BY display_order DESC, id DESC");
		$this->categories = array();
		$this->top_categories = array();
		$datas = $_top_categories = $_categories = array();
		
		//载入问题模块
		$item = $this->system->load_module('item');
		
		while($arr = $this->DB_master->fetch_array($query)){
			
			if(empty($arr['url'])){
				$arr['is_category'] = true;
				$arr['url'] = p8_url($item, $arr, 'list');
				unset($arr['is_category']);
			}
			
			if($write_cache){
				if(!$arr['display']){
					//如不显示,则删除缓存文件
					$CACHE->delete($this->system->name .'/modules/' , $this->name, (int)$arr['id']);
					continue;
				}

				$_categories[$arr['id']] = $this->categories[$arr['id']] = array(
					'id' => (int)$arr['id'],					
					'name' => $arr['name'],
					'parent' => (int)$arr['parent'],
					'item_count' => (int)$arr['item_count'],
					'display' => $arr['display'],
					'url' => $arr['url']
				);
				$datas[$arr['id']] = $arr;
			}else{
				$this->categories[$arr['id']] = $arr;
			}			
			
		}

		foreach($this->categories as $v){
			if($v['parent']){
				if($write_cache){
					$_tmp = array();
					$_parents = $this->get_parents($v['id']);
					//如果其中一级父类不显示,则不缓存和删除缓存文件
					foreach($_parents as $_p){
						if(!$_p['display']) break;
						$_tmp[] = $_p['id'];
					}
					if(empty($_tmp)){						
						$CACHE->delete($this->system->name .'/modules/' , $this->name, (int)$v['id']);
						continue;
					}
				}
				$this->categories[$v['parent']]['categories'][] = &$this->categories[$v['id']];
				$_categories[$v['parent']]['categories'][$v['id']] = &$_categories[$v['id']];
			}else{
				$this->top_categories[] = &$this->categories[$v['id']];
				$_top_categories[$v['id']] = &$_categories[$v['id']];
			}			
			
			//如果不是全部写缓存
			if($cache_all || $id == $v['id']){				
				$CACHE->write($this->system->name .'/modules/', $this->name, (int)$v['id'], $datas[$v['id']]);
			}
		}
		unset($datas);
		
		$this->data = array(
			'categories' => &$this->categories,
			'top_categories' => &$this->top_categories,
		);
		
		if($write_cache){			
			
			$json = array(
				'json' => jsonencode($_top_categories)
			);

			$path = array();
			foreach($this->categories as $v){
				$parents = $this->get_parents($v['id']);
				$tmp = array();
				foreach($parents as $p){
					if(!$p['display']) break;
					$tmp[] = $p['id'];
				}
				if(!empty($tmp) || !$v['parent']){
					$tmp[] = $v['id'];				
					$path[$v['id']] = $tmp;
				}
			}
			$json['path'] = jsonencode($path);

			$CACHE->write($this->system->name .'/modules/', $this->name, 'json', $json);
			$CACHE->write($this->system->name .'/modules/', $this->name, 'categories', $this->data, 'serialize');

		}
	}

	
		/**
	* 取得缓存的JSON
	**/
	function get_json(){
		global $CACHE;
		$json = $CACHE->read($this->system->name .'/modules', $this->name, 'json');
		return array(
			'json' => empty($json['json']) ? '{}' : $json['json'],
			'path' => empty($json['path']) ? '{}' : $json['path'],
		);
	}	
	/**
	 * 读取缓存
	 * param bool $read_cache 是否读取缓存
	 */
	function get_cache($read_cache = true){
		if(!empty($this->categories)) return;
		
		global $CACHE;
		
		if($read_cache){
			$this->data = $CACHE->read(
				$this->system->name .'/modules',
				$this->name,
				'categories',
				'serialize'
			);

			if(empty($this->data)) return array();

			$this->categories = &$this->data['categories'];
			$this->top_categories = &$this->data['top_categories'];
		}else{
			$this->cache(false, false);
		}
	}
    
	/**
	 * 获取父类
	 * param int $id 分类ID
	 */
	function get_parents($id){

		if(!isset($this->categories[$id])) return array();
		
		$p = $this->categories[$id]['parent'];
		$ps = array();
		while($p && !empty($this->categories[$p])){
			array_unshift($ps, $this->categories[$p]);
			unset($ps[0]['categories']);
			$p = $this->categories[$p]['parent'];
		}
		return $ps;
	}
	
	/**
	 * 获取子分类ID
	 */
	function get_children_ids($id){
		if(empty($this->categories[$id]['categories'])) return array();
		
		$ids = array();
		foreach($this->categories[$id]['categories'] as $v){
			$ids[$v['id']] = $v['id'];
			if(isset($v['categories']))
				$ids = $ids + $this->get_children_ids($v['id']);
		}
		
		return $ids;
	}
	
	/**
	 * 获取二级分类
	 * return array $datas 返回二级分类数组
	 */
	function get_second(){

		$datas = array();

		$this->cache(false,false);

		foreach($this->top_categories as $k=>$v){
			foreach($this->top_categories[$k] as $key=>$value){
				if(is_array($value)){
					foreach($value as $k2=>$v2){
						unset($v2['categories']);
						$datas[] = $v2;
					}
				}
			}
		}

		return $datas;

	}

	/**
	 * 获取单个分类
	 * param array &$params 数据
	 * param bool $read_cache 是否读取缓存
	 */
	function get_one($params, $read_cache){

		global $CACHE;

		if($read_cache){
			return $CACHE->read($this->system->name .'/modules/', $this->name, (int)$params['id']);
		}else{
			$item = $this->system->load_module('item');
			$data = $this->DB_master->fetch_one(
				"SELECT * FROM " . $this->table . " WHERE id='". $params['id'] . "'"
			);
			$data['url'] = p8_url($item, $data, 'list');
			return $data;
		}

	}

	/**
	 * 是否显示分类
	 * param string $condition 条件
	 * return array $data 返回数组
	*/
	function set_display($condition){

		$data = array();

		$query = $this->DB_master->query("SELECT id,display FROM " . $this->table . " WHERE $condition");
		while($row = $this->DB_master->fetch_array($query)){
			$display = $row['display']==1 ? 0 : 1;

			$this->DB_master->update(
				$this->table,
				array('display'=>$display),
				" id='".$row['id']."'"
				);

			$data[$row['id']] = $display;
		}

		$this->cache();

		return $data;
		
	}

	/**
	 * 更新分类排序
	 * @param array &$data 数据
	 * @param string $condition 条件
	 * @return int $affected_rows 返回影响数目
	 */
	function set_display_order(&$data, $condition){

		$affected_rows = $this->DB_master->update(
				$this->table,
				array('display_order'=>$data['display_order']),
				$condition
			);

		$this->cache();

		return $affected_rows;
		
	}


}