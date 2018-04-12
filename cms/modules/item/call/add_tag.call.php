<?php
defined('PHP168_PATH') or die();

//P8_CMS_Item::add_tag($str, $iid, $action = 'add')
	
	$tags = $this->get_tag($str, true);
	
	if(!$tags['array']) return false;
	
	$data = array();
	foreach($tags['tag_id'] as $tag => $id){
		$data[strtolower($tag)] = array($id, $iid);
	}
	
	$update_ids = $comma = '';
	foreach($tags['array'] as $tag){
		$_tag = strtolower($tag);
		if(isset($data[$_tag])){
			$update_ids .= $comma . $data[$_tag][0];
			$comma = ',';
			
			continue;
		}
		
		//new tag
		if($tid = $this->DB_master->insert(
			$this->tag_table,
			array('name' => $tag, 'item_count' => 1),
			array('return_id' => true)
		)){
			$data[$tag] = array($tid, $iid);
		}
	}
	
	if($update_ids && $action == 'add'){
		$this->DB_master->update(
			$this->tag_table,
			array('item_count' => 'item_count +1'),
			"id IN($update_ids)",
			false
		);
	}
	
	$action == 'update' && $this->DB_master->delete($this->tag_item_table, "iid = '$iid'");
	
	//replace into
	$data && $this->DB_master->insert(
		$this->tag_item_table,
		$data,
		array(
			'multiple' => array('tid', 'iid'),
			'replace' => true
		)
	);
	
	return true;