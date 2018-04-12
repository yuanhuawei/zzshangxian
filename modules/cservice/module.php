<?php
defined('PHP168_PATH') or die();
class P8_CService extends P8_Module{

var $table;
var $table_reply;

function P8_CService(&$system, $name){
	$this->system = &$system;
	//不可配置
	parent::__construct($name);
	
	$this->table = $this->TABLE_;
	$this->table_reply = $this->TABLE_ . "reply";
	
}

function add($data){
	$insert_id = $this->DB_master->insert(
		$this->table, 
		array(
			'num' => $data['num'],
			'uid' => $data['uid'],
			'username' => $data['username'],
			'mobilephone' => $data['mobilephone'],
			'ip' => $data['ip'],
			'site' => $data['site'],
			'title' => $data['title'],
			'priority' => $data['priority'],
			'category' => $data['category'],
			'timestamp' => P8_TIME,
		),
		array('return_id' => true)
	);
	$data['askid']=	$insert_id;
	$data['repid']=	0;
	//收集己上传的附件
	if(isset($data['attachment_hash'])){
		uploaded_attachments($this, $insert_id, $data['attachment_hash']);
		unset($data['attachment_hash']);
	}
	$this->reply($data,0);
}

function data($id){
	return $this->DB_master->fetch_one("SELECT a.*,s.content FROM $this->table AS a LEFT JOIN $this->table_reply as s ON a.id = s.askid WHERE a.id='$id'");

}
function reply($data){
	$this->DB_master->insert(
		$this->table_reply, 
		array(
			'askid' => $data['askid'],
			'repid' => $data['repid'],
			'uid' => $data['uid'],
			'username' => $data['username'],
			'title' => $data['title'],
			'frame' => $data['frame'],
			'timestamp' => P8_TIME,
			'content' => $data['content']
		),
		array('return_id' => true)
	);
	$this->set_state($data['askid'],$data['repid']?2:0);		
	
}
function updateask($data,$id){

	$this->DB_master->update(
		$this->table_reply, 
		array(
			'title' => $data['title'],
			'frame' => $data['frame'],
			'content' => $data['content']
		),
		"askid='$id'"
	);
    //收集己上传的附件
	if(isset($data['attachment_hash'])){
		uploaded_attachments($this, $id, $data['attachment_hash']);
		unset($data['attachment_hash']);
	}
	unset($data['content']);
	$this->DB_master->update(
		$this->table, 
		$data,
		"id='$id'"
	);
	
}
function updatereply($data){
	$this->DB_master->update(
		$this->table_reply, 
		array(
			'title' => $data['title'],
			'frame' => $data['frame'],
			'timestamp' => P8_TIME,
			'content' => $data['content']
		),
		"id='$data[replay_id]'"
	);
	$this->set_state($data['askid'],2);		
	
}
function delete($id){
	$this->DB_master->delete($this->table,"id='$id'");
	$this->DB_master->delete($this->table_reply,"askid='$id'");
}
function set_state($id,$state=0){
	global $UID,$USERNAME;

	$data['state']=$state;
	if($state==2){
		$data['adminuid']=$UID;
		$data['adminname']=$USERNAME;
		$data['solvetime']=P8_TIME;
	}
	$this->DB_master->update(
		$this->table,
		$data,
		"id='$id'"
	);
}
function get_my_info(){
	global $UID;
	$data1=$this->DB_master->fetch_one("SELECT count(*) as c FROM {$this->table} WHERE uid='$UID'");
	$data2=$this->DB_master->fetch_one("SELECT count(*) as c FROM {$this->table} WHERE uid='$UID' AND state='1'");
	$data['all']=$data1['c'];
	$data['ok']=$data2['c'];
	return $data;
	}
}