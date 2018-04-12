<?php

class P8_Area{

var $_data;
var $areas;
var $province;
var $table;

function P8_Area(){
	global $core;
	$this->table = $core->TABLE_ .'area';
}

function add($data){
	
	$data['parent'] = isset($data['parent']) ? intval($data['parent']) : 0;
	$data['name'] = isset($data['name']) ? html_entities($data['name']) : '';
	$data['display_order'] = isset($data['display_order']) ? intval($data['display_order']) : 0;
	
	global $core;
	return $core->DB_master->insert(
		$this->table,
		$data,
		array('return_id' => true)
	);
}

function update($id, $data){
	$data['parent'] = isset($data['parent']) ? intval($data['parent']) : 0;
	$data['name'] = isset($data['name']) ? html_entities($data['name']) : '';
	$data['display_order'] = isset($data['display_order']) ? intval($data['display_order']) : 0;
	
	$cids = $this->get_children_ids($id);
	array_push($cids, $id);
	//不能把父分类移动到子分类或者本身下面
	if(in_array($data['parent'], $cids)) return false;
	
	global $core;
	return $core->DB_master->update(
		$this->table,
		$data,
		"id = '$id'"
	);
}

function view($id){
	global $core;
	
	return $core->DB_master->fetch_one("SELECT * FROM $this->table WHERE id = '$id'");
}

function cache($write = true){
	global $core, $CACHE;
	
	$query = $core->DB_master->query("SELECT * FROM $this->table ORDER BY display_order DESC");
	$this->areas = array();
	$this->province = array();
	$_json_area = $_province = array();
	
	while($arr = $core->DB_master->fetch_array($query)){
		if($write){
			$this->areas[$arr['id']] = array(
				'id' => $arr['id'],
				'parent' => $arr['parent'],
				'name' => $arr['name']
			);
			
			$_json_area[$arr['id']] = array(
				'id' => $arr['id'],
				'parent' => $arr['parent'],
				'name' => $arr['name']
			);
		}else{
			$this->areas[$arr['id']] = $arr;
		}
	}
	
	foreach($this->areas as $id => $v){
		if($v['parent']){
			$this->areas[$v['parent']]['areas'][$v['id']] = &$this->areas[$v['id']];
			
			$_json_area[$v['parent']]['areas'][$v['id']] = &$_json_area[$v['id']];
		}else{
			$this->province[$v['id']] = &$this->areas[$v['id']];
			
			$_province[$v['id']] = &$_json_area[$v['id']];
		}
	}
	
	if($write){
		$path = array();
		foreach($this->areas as $v){
			$parents = $this->get_parents($v['id']);
			$tmp = array();
			foreach($parents as $vv){
				$tmp[] = $vv['id'];
			}
			$tmp[] = $v['id'];
			
			$path[$v['id']] = $tmp;
			/* if($v['parent'] == 0){
				$tmp = jsonencode(mb_unserialize(serialize($v)));
				write_file(PHP168_PATH .'js/area/'. $v['id'] .'.js', $tmp);
				//$CACHE->write('core', 'area', $v['id'], $tmp);
			} */
		}
		
		$this->_data = array(
			'province' => &$this->province,
			'areas' => &$this->areas
		);
		
		$_province = p8_json($_province);
		$path = p8_json($path);
		
		$CACHE->write('', 'core', 'area', $this->_data, 'serialize');
		$CACHE->write('', 'core', 'area_json', array('json' => $_province, 'path' => $path));
		
		//write_file(PHP168_PATH .'js/area_json.js', "var AREA_JSON = $_province;\r\nvar AREA_PATH = $path;");
	}
}

function get_json(){
	global $CACHE;
	return $CACHE->read('', 'core', 'area_json');
}

function get_cache(){
	global $CACHE;
	
	$this->_data = $CACHE->read('', 'core', 'area', 'serialize');
	
	$this->areas = &$this->_data['areas'];
	$this->province = &$this->_data['province'];
}

function get_parents($id){
	if(empty($this->areas[$id]['parent'])) return array();
	
	$p = $this->areas[$id]['parent'];
	$ps = array();
	while($p){
		array_unshift($ps, $this->areas[$p]);
		unset($ps[0]['areas']);
		$p = $this->areas[$p]['parent'];
	}
	return $ps;
}

function get_children_ids($id){
	if(empty($this->areas[$id]['areas'])) return array();
	
	$ids = array();
	foreach($this->areas[$id]['areas'] as $v){
		$ids[$v['id']] = $v['id'];
		if(isset($v['areas']))
			$ids = $ids + $this->get_children_ids($v['id']);
	}
	
	return $ids;
}

function delete($id){
	global $core;
	
	$cids = $this->get_children_ids($id);
	array_unshift($cids, $id);
	
	$ids = implode(',', $cids);
	
	return $core->DB_master->delete($this->table, "id IN ($ids)") ? $cids : array();
}

}