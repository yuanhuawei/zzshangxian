<?php
defined('PHP168_PATH') or die();

//P8_CMS_Item::list_order($id, $timestamp = 0){
	$ids = implode(',', (array)$id);
	
	if(!strlen($ids)){
		return false;
	}
	
	$_model = $this->model;
	
	$query = $this->DB_master->query("SELECT id, model, timestamp FROM $this->main_table WHERE id IN ($ids)");
	
	$models = array();
	$ids = $comma = '';
	while($arr = $this->DB_master->fetch_array($query)){
		//for sphinx
		$models[$arr['model']][$arr['id']] = array($timestamp ? $timestamp : intval($arr['timestamp']));
		
		$ids .= $comma . $arr['id'];
		$comma = ',';
	}

	$sphinx = !empty($this->CONFIG['sphinx']['enabled']) ?
		p8_sphinx($this->CONFIG['sphinx']['host'], $this->CONFIG['sphinx']['port']) :
		false;
	
	if($timestamp){
		
		//设置新的
		
		$this->DB_master->update(
			$this->main_table,
			array(
				'list_order' => $timestamp
			),
			"id IN ($ids)"
		);
		
		foreach($models as $mod => $v){
			$this->set_model($mod);
			
			$this->DB_master->update(
				$this->table,
				array(
					'list_order' => $timestamp
				),
				"id IN ($ids)"
			);
			
			$sphinx && $sphinx->UpdateAttributes(
				$this->system->name .'-item-'. $mod,
				array('list_order'),
				$v
			);
		}
		
		
	}else{
		
		//还原
		
		$this->DB_master->update(
			$this->main_table,
			array(
				'list_order' => 'timestamp'
			),
			"id IN ($ids)",
			false
		);
		
		foreach($models as $mod => $v){
			$this->set_model($mod);
			
			$this->DB_master->update(
				$this->table,
				array(
					'list_order' => 'timestamp'
				),
				"id IN ($ids)",
				false
			);
			
			$sphinx && $sphinx->UpdateAttributes(
				$this->system->name .'-item-'. $mod,
				array('list_order'),
				$v
			);
		}
	}
	
	$this->set_model($_model);
	
	return true;