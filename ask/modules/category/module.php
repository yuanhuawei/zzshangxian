<?php
class P8_Ask_Category extends P8_module{

	var $categories;		//�ܷ���,�ⲿ����ֱ�Ӵ���id $obj->categories[$id] ֱ�ӵõ���Ӧ�ķ���,������ķ��������ĸ�������,������ֱ�ӻ�����ӷ���ڵ�
	var $top_categories;	//��������,��������������,�������������ӷ�������νṹ����
	var $data;
	var $table;
	var $table_data;


	function P8_Ask_Category(&$system, $name){
		//��ģ��û������
		$this->configurable = false;
		$this->system = &$system;
		parent::__construct($name);
		
		$this->table = $this->TABLE_;
		$this->table_data = $this->TABLE_ . 'data';
	}

	/**
	 * ���������Ƿ����
	 * param string $condition ����
	 * return bool true||false ����:true,������:false
	 */
	function check_exists($condition){

		if($this->DB_master->fetch_one("SELECT id FROM " . $this->table . " WHERE $condition")){
			return true;
		}else{
			return false;
		}

	}
	
	/**
	 * ��ӷ���
	 * param array &$data ����
	 * return array $ids ������ӷ����ID�ַ���ֵ(��ʽ:1,2,3...)
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
	 * ɾ������
	 * @param string $condition ����
	 * @return int $affected_rows ����ɾ����Ŀ
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
	 * ���·���
	 * param int $id ����ID
	 * param array &$data ����
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
	 * ���·�����Ŀ
	 * param array &$data ����
	 * return int ����Ӱ����Ŀ
	*/
	function update_item_count($data){
		$this->cache(false, false);
		//����и�����ͬʱ���¸�����
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
	 * ���ɻ���
	 * param string $model ָ��ģ��,�����ָ��������������ģ�͵ķ���
	 * param bool $cache_all �Ƿ��ÿ�����඼�����һ�������ļ�
     * param bool $write_cache �Ƿ�д����,�����,��д����,�������νṹ,����ʵʱˢ��
     * param int $id ֻ����ķ����ID
	 */
	function cache($cache_all = true, $write_cache = true, $id = 0){
		parent::cache();
	
		global $CACHE;
		
		$query = $this->DB_master->query("SELECT * FROM $this->table ORDER BY display_order DESC, id DESC");
		$this->categories = array();
		$this->top_categories = array();
		$datas = $_top_categories = $_categories = array();
		
		//��������ģ��
		$item = $this->system->load_module('item');
		
		while($arr = $this->DB_master->fetch_array($query)){
			
			if(empty($arr['url'])){
				$arr['is_category'] = true;
				$arr['url'] = p8_url($item, $arr, 'list');
				unset($arr['is_category']);
			}
			
			if($write_cache){
				if(!$arr['display']){
					//�粻��ʾ,��ɾ�������ļ�
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
					//�������һ�����಻��ʾ,�򲻻����ɾ�������ļ�
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
			
			//�������ȫ��д����
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
	* ȡ�û����JSON
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
	 * ��ȡ����
	 * param bool $read_cache �Ƿ��ȡ����
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
	 * ��ȡ����
	 * param int $id ����ID
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
	 * ��ȡ�ӷ���ID
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
	 * ��ȡ��������
	 * return array $datas ���ض�����������
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
	 * ��ȡ��������
	 * param array &$params ����
	 * param bool $read_cache �Ƿ��ȡ����
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
	 * �Ƿ���ʾ����
	 * param string $condition ����
	 * return array $data ��������
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
	 * ���·�������
	 * @param array &$data ����
	 * @param string $condition ����
	 * @return int $affected_rows ����Ӱ����Ŀ
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