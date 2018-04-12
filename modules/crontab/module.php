<?php
defined('PHP168_PATH') or die();

class P8_Crontab extends P8_Module{

var $table;

function __construct(&$system, $name){
	$this->system = &$system;
	$this->configurable = false;
	//不可配置
	parent::__construct($name);
	
	$this->table = $this->TABLE_;
	
}

function P8_Crontab(&$system, $name){
	$this->__construct($system, $name);
}

/**
* @param string $name 计划名称
* @param string $script 脚本文件名
* @param int $day 每几天执行
* @param int $week 星期几执行
* @param int $month 每月哪天执行
* @param int $hour 几点执行
* 优先由$day,再到$week,最后$month, 如果前面都没有, 则只取$hour
* 如每天0点执行, $day = 1, $week = 0, $month = 0, $hour = 0
* 如每星期一0点执行, $day = 0, $week = 1, $month = 0, $hour = 0
* 如每月一号0点执行, $day = 0, $week = 0, $month = 1, $hour = 0
* 如每60天0点执行, $day = 60, $week = 0, $month = 0, $hour = 0
* 如果没设置天,星期,月,则由$hour负责每几个小时执行
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
* 选出一个任务来排队执行
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
* 执行任务,执行完成之后再弹出下一个任务来准备执行
* @param int $id 要执行任务的ID
**/
function run($id = 0){
	global $CACHE;
	if($CACHE->read('core/modules/', 'crontab', 'lock', 'serialize')){
		//有任务在进行了
		return false;
	}
	
	ignore_user_abort(true);
	
	if($id){
		//有ID情况下无论是否启动都要执行
		$task = $this->DB_master->fetch_one("SELECT * FROM $this->table WHERE id = '$id'");
	}else{
		$task = $this->DB_master->fetch_one("SELECT * FROM $this->table WHERE status = '1' ORDER BY next_run_time ASC LIMIT 1");
	}
	
	if(empty($task)) return false;
	
	$CACHE->write('core/modules/', 'crontab', 'lock', array($task['id']), 'serialize');
	//锁住,并发
	$pm = parse_url($task['script']);

	if(!empty($pm['query'])){
		parse_str($pm['query'],$param);
	   extract($param);
		$task['script']  = $pm['path'];
		unset($pm, $k, $v);
	 }
	//不要用require来执行,用require出错时会退出脚本
	include PHP168_PATH .'crontab/'. $task['script'];
	
	$time = $this->next_run_time($task);
	
	//更新本次执行时间以及下次执行时间
	$this->DB_master->update(
		$this->table,
		array(
			'last_run_time' => P8_TIME,
			'next_run_time' => $time,
		),
		"id = '$task[id]'"
	);
	
	//再选出一个任务来执行
	$this->pop();
	
	$CACHE->delete('core/modules/', 'crontab', 'lock');
	//解锁
	return true;
}

/**
* 取得下次任务的执行时间
* @param array $task 任务的执行频率
* @return int 时间戳
**/
function next_run_time($task){
	list($year, $month, $day, $week, $hour, $minute) = explode('|', date('Y|n|j|w|G|i', P8_TIME));		
	//年|月|日|星期几|小时|分钟
	
	$week = $week ? $week : 7;	//0为星期天
	$minute = intval($minute);	//使分钟成为整型
	
	if($task['day']){
		//按天执行
		return mktime($task['hour'], $task['minute'], 0, $month, $day + $task['day'], $year);
	}else if($task['week']){
		//按星期几执行
		$next_week = 7 - $week;	//离下星期还有几天
		return mktime($task['hour'], $task['minute'], 0, $month, $day + $next_week + $task['week'], $year);
	}else if($task['month']){
		//按每个月几号执行
		return mktime($task['hour'], $task['minute'], 0, $month + 1, $task['month'], $year);
	}else if($task['hour']){
		//按每几小时执行
		return mktime($hour + $task['hour'], $task['minute'], 0, $month, $day, $year);
	}else if($task['minute']){
		//按每几分钟执行
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