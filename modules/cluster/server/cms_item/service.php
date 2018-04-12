<?php
defined('PHP168_PATH') or die();

class P8_Cluster_CMS_Item_S extends P8_Cluster_Service{

var $table;
var $category;

function __construct(&$cluster, $side, $name){
	$this->cluster = &$cluster;
	parent::__construct($side, $name);
	
	$this->table = $this->TABLE_ .'push_item';
}

function P8_Cluster_CMS_Item_S(&$cluster, $side, $name){
	$this->__construct($cluster, $side, $name);
}

/**
* 加载分类功能
**/
function &category(){
	if(!$this->category){
		$this->category = &new P8_Cluster_CMS_Category_S($this);
	}
	return $this->category;
}

function cache(){
	parent::cache();
	
	$this->category();
	$this->category->cache();
}

/**
* 接收客户端推送的数据
**/
function receive(&$data){
	
	global $client_id;
	
	$d = $rec = array();
	$category_count = array();
	$tmp=array();
	$i = 0;
	foreach($data as $v){
		//客户端的内容ID
		$client_item_id = $v['id'];
		unset($v['id']);
		
		$d[$i] = array(
			'client_id' => $client_id,
			'client_item_id' => $v['client_item_id'],
			'cid' => $v['cid'],
			'model' => $v['model'],
			'title' => $v['title'],
			'data' => $v,
			'timestamp' => P8_TIME
		);
		
		$tmp[$i]['data'] = $d[$i]['data'];
		$d[$i]['data'] = $this->cluster->core->DB_master->escape_string(serialize($d[$i]['data']));
		$d[$i]['push_item_id'] = $this->cluster->core->DB_master->insert(
			$this->table,
			$d[$i],
			array('replace' => true,'return_id'=>true	)
		);
		if(!empty($this->CONFIG['auto_receive'])){
			$d[$i]['data']=$tmp[$i]['data'];
		}
		
		$category_count[$v['cid']] = isset($category_count[$v['cid']]) ? $category_count[$v['cid']] +1 : 1;
		
		$i++;
	}
	unset($data);
	
	//replace into
	if($i){
		$category = &$this->category();
		foreach($category_count as $cid => $count){
			$category->update_count($cid, $count);
		}
		
		if(!empty($this->CONFIG['auto_receive'])){
			//自动接收, 调用客户端的服务入库
			$receiver = &$this->cluster->load_service('client', $this->name);
			$receiver->receive($d);
		}
		
		return $i;
	}
	
	return 0;
}

/**
* 删除数据
**/
function delete($data){

	$category_item_count = array();
	$ids = $comma = '';
	
	$query = $this->cluster->core->DB_master->query("SELECT id, cid FROM $this->table WHERE $data[where]");
	while($arr = $this->cluster->core->DB_master->fetch_array($query)){
		$category_item_count[$arr['cid']] = isset($category_item_count[$arr['cid']]) ? $category_item_count[$arr['cid']] +1 : 1;
		
		$ids .= $comma . $arr['id'];
		$comma = ',';
	}
	
	$num = 0;
	
	if(
		$ids && $num = $this->cluster->core->DB_master->delete($this->table, "id IN ($ids)")
	){
		$category = &$this->category();
		
		//批量更新分类内容数
		foreach($category_item_count as $cid => $count){
			$category->update_count($cid, -$count);
		}
	}
	
	return $num;
}

}
























/**
* 分类
**/
class P8_Cluster_CMS_Category_S{

var $service;
var $data;
var $categories;
var $top_categories;
var $table;
var $core;
var $DB_master;
var $DB_slave;

function P8_Cluster_CMS_Category_S(&$service){
	$this->service = &$service;
	$this->table = $this->service->TABLE_ .'category';
	$this->core = &$this->service->core;
	$this->DB_master = &$this->core->DB_master;
	$this->DB_slave = &$this->core->DB_slave;
}

function add($data){
	$_data = array(
		'parent' => isset($data['parent']) ? intval($data['parent']) : 0,
		'name' => isset($data['name']) ? html_entities($data['name']) : 0,
		'display_order' => isset($data['display_order']) ? intval($data['display_order']) : 0
	);
	
	return $this->DB_master->insert(
		$this->table,
		$_data,
		array('return_id' => true)
	);
}

function update($id, $data){
	$_data = array(
		'parent' => isset($data['parent']) ? intval($data['parent']) : 0,
		'name' => isset($data['name']) ? html_entities($data['name']) : 0,
		'display_order' => isset($data['display_order']) ? intval($data['display_order']) : 0
	);
	
	//不能移动到本身和子分类去
	if(in_array($_data['parent'], $this->get_children_ids($id) + array($id))) return false;
	
	return $this->DB_master->update(
		$this->table,
		$_data,
		"id = '$id'"
	);
}

function delete($data){
	$query = $this->DB_master->query("SELECT id FROM $this->table WHERE $data[where]");
	$id = array();
	$this->get_cache();
	while($arr = $this->DB_master->fetch_array($query)){
		$id[] = $arr['id'];
		//连同子分类一起删除
		$cids = $this->get_children_ids($arr['id']);
		$id = array_merge($id, $cids);
	}
	
	$ids = implode(',', $id);
	
	if($ids && $status = $this->DB_master->delete($this->table, "id IN ($ids)")){
		
		return $this->service->delete(array(
			'where' => 'cid IN ('. $ids .')'
		));
	}
	
	return false;
}

function update_count($id, $num){
	$this->get_cache();
	
	if(empty($this->categories[$id]) || empty($num)) return false;
	
	$ids = $id;
	//如果有父分类同时更新父分类
	if($parents = $this->get_parents($id)){
		$ids = '';
		foreach($parents as $v){
			$ids .= ',' . $v['id'];
		}
		$ids = $id . $ids;
	}
	
	return $this->DB_master->update(
		$this->table,
		array(
			'item_count' => 'item_count + '. $num
		),
		"id IN ($ids)",
		false
	);
}

function cache($write_cache = true){
	return include $this->service->path .'call/cache_category.call.php';
}

function get_json(){
	return $this->service->read_cache('category_json');
}

function get_cache($read_cache = true){
	if(!empty($this->categories)) return;
	
	if(
		$read_cache &&
		$this->data = $this->service->read_cache(
			'categories',
			'serialize'
		)
	){
		$this->categories = &$this->data['categories'];
		$this->top_categories = &$this->data['top_categories'];
	}else{
		$this->cache(false);
	}
}

function get_parents($id){
	if(!isset($this->categories[$id])) return array();
	
	$p = $this->categories[$id]['parent'];
	$ps = array();
	while($p){
		array_unshift($ps, $this->categories[$p]);
		unset($ps[0]['categories']);
		$p = $this->categories[$p]['parent'];
	}
	return $ps;
}

/**
* 取得分类的所有子分类的ID
* @param int $id 分类ID
**/
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
	
}