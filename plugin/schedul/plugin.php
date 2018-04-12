<?php
defined('PHP168_PATH') or die();

class P8_Plugin_Schedul extends P8_Plugin{

private $appkey;

function __construct(&$core, $name){
	$this->core = &$core;
	parent::__construct($name);
	$this->table = $this->TABLE_;
}

function P8_Plugin_Schedul(&$core, $name){
	$this->__construct($core, $name);
}

function _cache(){
	rm(CACHE_PATH .'core/plugin/schedul/date', true);
}

function get_data($id){
	$sql = "SELECT * FROM {$this->table} WHERE id='$id'";
	$query = $this->DB_slave->fetch_all($sql);
	return $query?$query[0]:array();
}

function add($data){
	return $this->DB_slave->insert(
		$this->table,
		$data,
		true
	);

}
function listorder($data){
	return $this->DB_slave->update(
		$this->table,
		$data,
		"id=$id"
	);

}

function update($id,$data){
	return $this->DB_slave->update(
		$this->table,
		$data,
		"id=$id"
	);

}
function delete($id){
	return $this->DB_slave->delete(
		$this->table,
		"id=$id"
	);

}

function get_date($date, $reflash=false){
	if($reflash || !$return = $this->core->CACHE->read('core/plugin/schedul', 'date', $date)){
		$nextdate_1 = date('Y-m-d',strtotime($date)+86400);
		$nextdate_2 = date('Y-m-d',strtotime($date)+86400*2);
		$dat = "'$date','$nextdate_1','$nextdate_2'";
		$sql = "SELECT * FROM {$this->table} WHERE date IN($dat) ORDER BY date DESC, list_order ASC, id ASC";
		$return = $this->DB_slave->fetch_all($sql);
		 $this->core->CACHE->write('core/plugin/schedul', 'date', $date, $return);
	}
	return $return?$return:array();
}

function _display(){
global $P8LANG;
	
	$predate = date('Y-m-d',time()-86400);
	$date = date('Y-m-d');
	$w = date('w');
	$w = $P8LANG['week_'.($w?$w:7)];
	$nextdate = date('Y-m-d',time()+86400);
	$url = $this->controller;
	$list = $this->get_date($date);
	//用数据包含模板取得标签内容
		ob_start();
		include $this->template('_display');
		$content = ob_get_clean();
	echo $content;
}

}