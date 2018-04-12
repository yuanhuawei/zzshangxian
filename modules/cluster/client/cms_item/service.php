<?php
defined('PHP168_PATH') or die();

class P8_Cluster_CMS_Item_C extends P8_Cluster_Service{

var $category;

function __construct(&$cluster, $side, $name){
	$this->cluster = &$cluster;
	parent::__construct($side, $name);
}

function P8_Cluster_CMS_Item_C(&$cluster, $side, $name){
	$this->__construct($cluster, $side, $name);
}

function &category(){
	if(!$this->category){
		$this->category = &new P8_Cluster_CMS_Category_C($this);
	}
	return $this->category;
}

/**
* 接收服务端的推送数据
**/
function receive(&$data){
	
	if(empty($this->CONFIG['map'])){
		//没有设置映射
		return array();
	}
	
	$map = $this->CONFIG['map'];

	//加载本地相关模块
	$cms = &$this->cluster->core->load_system('cms');
	$item = &$cms->load_module('item');
	$controller = &$this->cluster->core->controller($item);
	
	$self_client = $this->get_self_client();
	$ret = array();
	foreach($data as $v){
		if($self_client && $v['client_id']==$self_client){
			continue;
		}	
		//没有设置这个分类的对接或默认的对接
		if(isset($map[$v['cid']])){
			$cid = $map[$v['cid']];
		}else if(isset($map[0])){
			$cid = $map[0];
		}else{
			continue;
		}
		
		$_REQUEST['model'] = $v['model'];
		$cms->init_model();
		$item->set_model($_REQUEST['model']);
		$v['data']['cid'] = $cid;
		$v['data']['verify'] = empty($this->CONFIG['auto_verify']) ? 0 : 1;
		$v['data']['push_item_id'] = $v['push_item_id'];
		
		$client = $this->cluster->CONFIG['server_side']['clients'][$v['client_id']];
		//没有来源设置一下
		empty($v['data']['source']) && $v['data']['source'] = $client['name'] .'|'. $client['url'];
		
		if($id = $controller->add($v['data'])){
			$ret[] = $id;
			$v['data']['verify'] && $this->set_push_item_status($v['push_item_id'],1);
			//追加
			if(!empty($v['data']['addon'])){
				foreach($v['data']['addon'] as $vv){
					$vv['iid'] = $id;
					
					$controller->addon($vv);
				}
			}
		}
		
		unset($cid);
	}
	
	return $ret;
}

function get_self_client(){
	$selfclient = $this->cluster->core->url.'/index.php/core/cluster-client';
	$sql = "SELECT id FROM {$this->cluster->client_table} WHERE client_url='$selfclient'";
	$query = $this->cluster->DB_master->fetch_one($sql);
	$client_id = $query['id'];
	return $client_id;
}

function set_push_item_status($push_item_id,$status=1){
	$cms_item_server  = $this->cluster->load_service('server','cms_item');
	$sql = "UPDATE {$cms_item_server->table} SET status='$status' WHERE id='$push_item_id'";
	 $this->cluster->DB_master->query($sql);
}
}































class P8_Cluster_CMS_Category_C{

var $service;
var $data;
var $categories;
var $top_categories;

function P8_Cluster_CMS_Category_C(&$service){
	$this->service = &$service;
}

function get_cache(){
	if(!empty($this->categories)) return;
	
	$p = array();
	$this->data = $this->service->cluster->server_call('cms_item', 'get_category', $p);
	$this->categories = &$this->data['categories'];
	$this->top_categories = &$this->data['top_categories'];
}

function get_json(){
	$p = array('type' => 'json');
	return $this->service->cluster->server_call('cms_item', 'get_category', $p);
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