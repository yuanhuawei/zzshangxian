<?php
defined('PHP168_PATH') or die();

class P8_ShortcutSms extends P8_Module{

var $table;

function __construct(&$system, $name){
	$this->system = &$system;

	parent::__construct($name);
	
	//$this->table = $this->TABLE_;
	$this->table = 'p8_shortcutsms_data';
}
	
function P8_ShortcutSms(&$system, $name){
	$this->__construct($system, $name);
}

function get($id){
	return $this->DB_slave->fetch_one("SELECT * FROM $this->table WHERE id = '$id'");
}

function getALL(){
	return $this->DB_slave->fetch_All("SELECT * FROM $this->table");
}

/**
* 添加客户
**/
function add(&$data){
	global $UID, $USERNAME;
	//$data['username'] = $USERNAME;
	$data['timestamp'] = P8_TIME;
	
	$id = $this->DB_master->insert(
		$this->table,
		$data,
		array('return_id' => true)
	);
	
	return $id;
}

/**
* 修改客户
**/
function update($id, &$data){
	
	//$hash = isset($data['attachment_hash']) ? $data['attachment_hash'] : array();
	//unset($data['attachment_hash'], $data['options']);
	//$data['timestamp'] = P8_TIME;
	$status = $this->DB_master->update(
		$this->table,
		$data,
		"id = '$id'"
	);
	
	//uploaded_attachments($this, $id, $hash);
	
	return $status;
}

/**
* 删除
**/
function delete($data){
	
	$query = $this->DB_master->query("SELECT id FROM $this->table WHERE $data[where]");
	$ids = $comma = '';
	while($arr = $this->DB_master->fetch_array($query)){
		$ids .= $comma . $arr['id'];
		$comma = ',';
	}
	
	if($ids && $status = $this->DB_master->delete(
		$this->table,
		"id IN ($ids)"
	)){
		//删除日志
		$this->DB_master->delete(
			$this->log_table,
			"cid IN ($ids)"
		);
	}
	
	return $status;
}

}