<?php
defined('PHP168_PATH') or die();

class P8_Crontab extends P8_Module{

var $table;

function __construct(&$system, $name){
	$this->system = &$system;
	$this->configurable = false;
	//��������
	parent::__construct($name);
	
	$this->table = $this->TABLE_;
	
}

function P8_Crontab(&$system, $name){
	$this->__construct($system, $name);
}

/**
* @param string $name �ƻ�����
* @param string $script �ű��ļ���
* @param int $day ÿ����ִ��
* @param int $week ���ڼ�ִ��
* @param int $month ÿ������ִ��
* @param int $hour ����ִ��
* ������$day,�ٵ�$week,���$month, ���ǰ�涼û��, ��ֻȡ$hour
* ��ÿ��0��ִ��, $day = 1, $week = 0, $month = 0, $hour = 0
* ��ÿ����һ0��ִ��, $day = 0, $week = 1, $month = 0, $hour = 0
* ��ÿ��һ��0��ִ��, $day = 0, $week = 0, $month = 1, $hour = 0
* ��ÿ60��0��ִ��, $day = 60, $week = 0, $month = 0, $hour = 0
* ���û������,����,��,����$hour����ÿ����Сʱִ��
**/
function add($data){
	$next_run_time = $this->next_run_time($data);
	
	$id = $this->DB_master->insert(
		$this->table,
		array(
			'name' => $data['name'],
			'script' => $data['script'],
			'day' => $data['day'],
			'week' => $data['week'],
			'month' => $data['month'],
			'hour' => $data['hour'],
			'minute' => $data['minute'],
			'next_run_time' => $next_run_time,
			'status' => $data['status']
		),
		array('return_id' => true)
	);
	
	if($id)
		$this->pop();
		
	return $id;
}

function update($id, $data){
	$next_run_time = $this->next_run_time($data);
	
	$rows = $this->DB_master->update(
		$this->table,
		array(
			'name' => $data['name'],
			'script' => $data['script'],
			'day' => $data['day'],
			'week' => $data['week'],
			'month' => $data['month'],
			'hour' => $data['hour'],
			'minute' => $data['minute'],
			'status' => $data['status'],
			'next_run_time' => $next_run_time
		),
		"id = '$id'"
	);
	
	if($rows)
		$this->pop();
		
	return $rows;
}

function delete($id){
	if(is_array($id))
		$id = implode(',', $id);
	
	return $this->DB_master->delete($this->table, "id IN ($id)");
}

/**
* ѡ��һ���������Ŷ�ִ��
* 
**/
function pop(){
	$task = $this->DB_master->fetch_one("SELECT next_run_time FROM $this->table WHERE status = '1' ORDER BY next_run_time ASC LIMIT 1");
	//echo date('Y-m-d H:i:s', $task['next_run_time']) .'<br />'. date('Y-m-d H:i:s', P8_TIME);
	if(!empty($task))
		$this->core->set_config(array('next_crontab' => $task['next_run_time']));
	
	return true;
}

/**
* ִ������,ִ�����֮���ٵ�����һ��������׼��ִ��
* @param int $id Ҫִ�������ID
**/
function run($id = 0){
	global $CACHE;
	if($CACHE->read('core/modules/', 'crontab', 'lock', 'serialize')){
		//�������ڽ�����
		return false;
	}
	
	ignore_user_abort(true);
	
	if($id){
		//��ID����������Ƿ�������Ҫִ��
		$task = $this->DB_master->fetch_one("SELECT * FROM $this->table WHERE id = '$id'");
	}else{
		$task = $this->DB_master->fetch_one("SELECT * FROM $this->table WHERE status = '1' ORDER BY next_run_time ASC LIMIT 1");
	}
	
	if(empty($task)) return false;
	
	$CACHE->write('core/modules/', 'crontab', 'lock', array($task['id']), 'serialize');
	//��ס,����
	$pm = parse_url($task['script']);

	if(!empty($pm['query'])){
		parse_str($pm['query'],$param);
	   extract($param);
		$task['script']  = $pm['path'];
		unset($pm, $k, $v);
	 }
	//��Ҫ��require��ִ��,��require����ʱ���˳��ű�
	include PHP168_PATH .'crontab/'. $task['script'];
	
	$time = $this->next_run_time($task);
	
	//���±���ִ��ʱ���Լ��´�ִ��ʱ��
	$this->DB_master->update(
		$this->table,
		array(
			'last_run_time' => P8_TIME,
			'next_run_time' => $time,
		),
		"id = '$task[id]'"
	);
	
	//��ѡ��һ��������ִ��
	$this->pop();
	
	$CACHE->delete('core/modules/', 'crontab', 'lock');
	//����
	return true;
}

/**
* ȡ���´������ִ��ʱ��
* @param array $task �����ִ��Ƶ��
* @return int ʱ���
**/
function next_run_time($task){
	list($year, $month, $day, $week, $hour, $minute) = explode('|', date('Y|n|j|w|G|i', P8_TIME));		
	//��|��|��|���ڼ�|Сʱ|����
	
	$week = $week ? $week : 7;	//0Ϊ������
	$minute = intval($minute);	//ʹ���ӳ�Ϊ����
	
	if($task['day']){
		//����ִ��
		return mktime($task['hour'], $task['minute'], 0, $month, $day + $task['day'], $year);
	}else if($task['week']){
		//�����ڼ�ִ��
		$next_week = 7 - $week;	//�������ڻ��м���
		return mktime($task['hour'], $task['minute'], 0, $month, $day + $next_week + $task['week'], $year);
	}else if($task['month']){
		//��ÿ���¼���ִ��
		return mktime($task['hour'], $task['minute'], 0, $month + 1, $task['month'], $year);
	}else if($task['hour']){
		//��ÿ��Сʱִ��
		return mktime($hour + $task['hour'], $task['minute'], 0, $month, $day, $year);
	}else if($task['minute']){
		//��ÿ������ִ��
		return mktime($hour, $minute + $task['minute'], 0, $month, $day, $year);
	}
}

function run_interval($task){
	if($task['day']){
		return 'day';
	}else if($task['week']){
		return 'week';
	}else if($task['month']){
		return 'month';
	}else if($task['hour']){
		return 'hour';
	}else if($task['minute']){
		return 'minute';
	}
}

}