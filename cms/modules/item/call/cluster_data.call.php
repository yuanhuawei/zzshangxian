<?php
defined('PHP168_PATH') or die();

//P8_CMS_Item::cluster_data($id, $cid)
	
	$id = (array)$id;
	$ids = implode(',', $id);
	
	$ret = array();
	$query = $this->DB_slave->query("SELECT id, model FROM $this->main_table WHERE id IN ($ids)");
	
	$data = array();
	$i = 0;
	while($arr = $this->DB_slave->fetch_array($query)){
		$model = $this->system->get_model($arr['model']);
		$_REQUEST['model'] = $arr['model'];
		$this->system->init_model();
		$this->set_model($arr['model']);
		
		$data[$i] = $this->DB_slave->fetch_one("SELECT * FROM $this->table AS i INNER JOIN $this->addon_table AS a ON i.id = a.iid WHERE i.id = '$arr[id]' AND page = '1'");
		
		$data[$i]['client_item_id'] = $arr['id'];
		$data[$i]['cid'] = $cid;
		$data[$i]['model'] = $arr['model'];
		$data[$i]['frame'] = attachment_url($data[$i]['frame']);
		$data[$i]['comments'] = 0;
		$data[$i]['views'] = 0;
		$data[$i]['vid'] = 0;
		$data[$i]['attributes'] = '';
		$data[$i]['action'] = 'add';
		
		$this->format_data($data[$i]);
		
		foreach($model['fields'] as $field => $field_data){
			
			//引用
			$data[$i]['field#'][$field] = &$data[$i][$field];
			//$data[$i]['field#'][$field] = &$data[$i][$field];
			//unset($data[$i][$field]);
		}
		
		unset($data[$i]['label_postfix']);
		
		//追加数据
		$_query = $this->DB_slave->query("SELECT * FROM $this->addon_table WHERE iid = '$arr[id]' AND page != '1' ORDER BY page ASC");
		$j = 0;
		while($addon = $this->DB_slave->fetch_array($_query)){
			unset($addon['id'], $addon['iid'], $addon['page']);
			$data[$i]['addon'][$j] = $addon;
			
			$this->format_data($data[$i]['addon'][$j]);
			
			foreach($model['fields'] as $field => $field_data){
				if(!isset($addon[$field])) continue;
				
				//引用
				$data[$i]['addon'][$j]['field#'][$field] = &$data[$i]['addon'][$j][$field];
				//$data[$i]['addon'][$j]['field#'][$field] = &$data[$i]['addon'][$j][$field];
				//unset($data[$i]['addon'][$j][$field]);
			}
			
			$j++;
		}
		
		$i++;
	}
	
	return $data;