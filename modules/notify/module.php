<?php
defined('PHP168_PATH') or die();

class P8_Notify extends P8_Module{

var $table;
var $sign_in_table;

function __construct(&$system, $name){
	$this->system = &$system;
	parent::__construct($name);
	
	$this->table = $this->TABLE_;
	$this->sign_in_table = $this->TABLE_ .'sign_in';
}

function P8_Notify(&$system, $name){
	$this->__construct($system, $name);
}

/**
* д֪ͨ
**/
function add(&$data){
	
	$id = $this->DB_master->insert(
		$this->table,
		$data,
		array('return_id' => true)
	);
	
	return $id;
}

/**
* �޸�֪ͨ
**/
function update($id, &$data){
	if($status = $this->DB_master->update(
		$this->table,
		$data,
		"id = '$id'"
	)){
		
	}
	
	return $status;
}

/**
* ɾ��֪ͨ
**/
function delete($data){
	$query = $this->DB_master->query("SELECT * FROM $this->table WHERE $data[where]");
	
	$ids = $comma = '';
	while($arr = $this->DB_master->fetch_array($query)){
		$ids .= $comma . $arr['id'];
		$comma = ',';
	}
	
	if(
		$ids && $this->DB_master->delete($this->table, "id IN ($ids)")
	){
		//ɾ��ǩ��
		$this->DB_master->delete($this->sign_in_table, "nid IN ($ids)");
	}else{
		return false;
	}
	
	return true;
}

/**
* ɾ��ǩ��
**/
function delete_sign($data){
	$query = $this->DB_master->query("SELECT * FROM $this->sign_in_table WHERE $data[where]");
	if(!$query)return false;
	$this->DB_master->delete($this->sign_in_table,$data['where']);
	//����ǩ����
	$send = $sign = 0;
	foreach($query as $key => $val){
		$send++;
		if($val['timestamp'])$sign++;
	}
	$this->DB_master->update(
			$this->table,
			array(
				'send_count' => 'send_count -'.$send,
				'sign_in_count' => 'sign_in_count -'.$sign
			),
			"id = '$data[id]'",
			false
	);	
	return true;
}
/**
* ����
**/
function send($id){
	
}

function view($id){
	return $this->DB_master->fetch_one("SELECT * FROM $this->table WHERE id = '$id'");
}

/**
* ǩ��
**/
function sign_in(&$data, $sms = false){
	$sign_in = $this->DB_master->fetch_one("SELECT * FROM $this->sign_in_table WHERE nid = '$data[id]' AND uid = '$data[uid]'");
	if(
		empty($sign_in) || 
		!$sms && $sign_in['hash'] != $data['hash']
	) return false;
	
	$this->DB_master->update(
		$this->sign_in_table,
		array(
			'timestamp' => P8_TIME,
			'status' => $data['status'],
			'receive' => 1,
			'comment' => $data['comment']
		),
		"nid = '$data[id]' AND uid = '$data[uid]'"
	);
	
	//����ǩ����
	if(!$sign_in['timestamp']){
		$this->DB_master->update(
			$this->table,
			array(
				'sign_in_count' => 'sign_in_count +1'
			),
			"id = '$data[id]'",
			false
		);
	}	
	return true;
}

/**
* ����ǩ�� callback
* @param string $number �ظ�����
* @param string $message �ظ���Ϣ
* @param array $data ����ʱ�Ļص�ͷ
**/
function sms_sign_in($number, $message, $data){
	
	$id = intval(array_shift($data));
	if(empty($id)) return null;
	
	$status = 1;
	if(count($tmp = explode(' ', $message, 2)) > 1){
		//״̬ ��Ϣ �ָ�
		$status = intval($tmp[0]);
		$message = $tmp[1];
	}
	
	//���ֻ�����ȡ���û���
	$member = $this->core->DB_slave->fetch_one("SELECT id, username FROM {$this->core->member_table} WHERE cell_phone = '$number'");
	if(empty($member)) return null;
	
	$param = array('id' => $id, 'uid' => $member['id'], 'status' => $status, 'comment' => $message);
	
	return $this->sign_in($param, true);
}
/**
*�ҵ�֪ͨ
**/
function get_my_notify($uid,$start=0,$length=20){
	$query =  $this->DB_master->query("SELECT nid FROM {$this->sign_in_table} WHERE uid = '$uid'  ORDER BY nid DESC LIMIT $start,$length");
	$ids=array();
	while($rs = $this->DB_master->fetch_array($query)){
		$ids[]=$rs['nid'];
	}
	return $ids;
}
/**
*֪ͨ����
**/
function check_notify($id){
	$query = $this->core->DB_slave->fetch_one("SELECT send_count, sign_in_count FROM {$this->table} WHERE id = '$id'");
	return(array(
		'send_count'=> $query['send_count'],
		'sign_count'=> $query['sign_in_count'],
		'unsign_count'=> max(0,$query['send_count']-$query['sign_in_count']),
		'status_count'=> $this->status_count($id)
		)
	);
}
/**
*һ��ǩ��
**/
function check_one_sign($id,$uid){
	return $this->core->DB_slave->fetch_one("SELECT * FROM {$this->sign_in_table} WHERE nid = '$id' AND uid = '$uid'");
	
}
function status_count($id){
	$query = $this->core->DB_slave->fetch_all("SELECT status FROM {$this->sign_in_table} WHERE nid = '$id'");
	$status = array();
	foreach($this->CONFIG['status'] as $key => $st){
		$status[$key]['name'] = $st;
		$status[$key]['count'] = 0;
	}
	foreach($query as $key => $rs){
		$status[$rs['status']]['count']+=1;
	}
	unset($status['0']);
	return $status;
}
}