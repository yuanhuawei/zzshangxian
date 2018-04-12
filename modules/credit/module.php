<?php
defined('PHP168_PATH') or die();

class P8_Credit extends P8_Module{

var $table;						//�������ͱ�
var $rule_table;				//�����
var $log_table;					//���ֵ�ʧ��־��
var $rule_log_table;			//����Ӧ����־��
var $rule_log_cache_table;		//������־�����
var $credits;
var $rules;
var $last_cache;

function __construct(&$system, $name){
	//��ģ��û������
	$this->configurable = false;
	$this->system = &$system;
	parent::__construct($name);
	
	$this->table = $this->core->TABLE_ .'credit';
	$this->member_table = $this->TABLE_ .'member';
	$this->rule_table = $this->TABLE_ .'rule';
	$this->log_table = $this->TABLE_ .'log';
	$this->rule_log_table = $this->TABLE_ .'rule_log';
	$this->rule_log_cache_table = $this->TABLE_ .'rule_log_cache';
	
	$this->last_cache = '@'. $this->core->CONFIG['last_credit_cache'];
}

function P8_Credit(&$system, $name){
	$this->__construct($system, $name);
}

/**
* ��ӻ�������
* $type ������С��,ֻ��������float_bit��ΪС��,float_pointΪС����λ��
* $is_unsigned �Ƿ����Ϊ������,Ĭ�ϲ�����
* $default_value ���ֵ�Ĭ��ֵ
**/
function add($data){
	$id = $this->DB_master->insert(
		$this->table,
		$data,
		array('return_id' => true)
	);
	
	$is_unsigned = $data['is_unsigned'] ? 'unsigned' : '';
	$type = $data['float_bit'] ? "decimal({$data['float_bit']},{$data['float_point']})" : "int";
	$this->DB_master->query("ALTER TABLE $this->member_table ADD COLUMN credit_$id $type $is_unsigned NOT NULL DEFAULT '{$data['default_value']}'");
	$this->DB_master->query("ALTER TABLE {$this->core->TABLE_}role ADD COLUMN credit_$id $type $is_unsigned NOT NULL DEFAULT '0'");
	
	return $id;
}

/**
* ɾ����������
**/
function delete($id){
	if(
		$status = $this->DB_master->delete(
			$this->table,
			"id = '$id'"
		)
	){
		//ɾ����Ӧ����
		$this->DB_master->delete($this->rule_table, "credit_id = '$id'");
		//ɾ����Ӧ�ֶ�
		$this->DB_master->query("ALTER TABLE $this->member_table DROP COLUMN credit_$id");
		$this->DB_master->query("ALTER TABLE ". $this->core->TABLE_ ."role DROP COLUMN credit_$id");
		return $status;
	}
	
}

/**
* �޸Ļ�������,����ͬ���
**/
function update($id, $data){
	if(
		$this->DB_master->update(
			$this->table,
			$data,
			"id = '$id'"
		)
	){
		$is_unsigned = $data['is_unsigned'] ? 'unsigned' : '';
		$type = $data['float_bit'] ? "decimal({$data['float_bit']},{$data['float_point']})" : "int";
		
		return $this->DB_master->query("ALTER TABLE $this->member_table CHANGE credit_$id credit_$id $type $is_unsigned NOT NULL DEFAULT '{$data['default_value']}'");
	}
}

/**
* Ӧ�û��ֹ���,��ģ�Ͳ������
* @param object $obj ϵͳ��ģ���ģ�Ͳ����
* @param string $action ����
* @param int $uid �û�ID
* @param int $role_id �û��Ľ�ɫ
* @param string $postfix �Զ����RULE��׺
**/
function apply_rule(&$obj, $action, $uid, $role_id, $postfix = ''){
	if(empty($uid) || empty($action)) return false;
	/*
	$rule = [system][module][role_id][postfix]
	*/
	
	switch($obj->type){
	
	case 'core':
	case 'system':
		$system = $obj->name;
		$module = '';
	break;
	
	case 'module':
		$system = $obj->system->name;
		$module = $obj->name;
	break;
	
	default:
		return false;
	
	}
	
	if(is_array($postfix)){
		//��������һ����׺ array(1, 2, 3),��׺ʹ��˳��Ϊ����1,���1�ҵ���ֱ��ʹ��1,���û�ҵ���2,��������
		foreach($postfix as $v){
			if(empty($this->rules[$system][$module][$role_id][$v])){
				$this->get_cache_rule($system, $module, $role_id, $v);
				
				if(!empty($this->rules[$system][$module][$role_id][$v])){
					$postfix = $v;
					break;
				}
			}
		}
	}else{
		//�ӻ����ж�ȡ����
		empty($this->rules[$system][$module][$role_id][$postfix]) &&
		$this->get_cache_rule($system, $module, $role_id, $postfix);
	}
	
	//�����������Ȼû�й���,ֱ���˳� 
	if(empty($this->rules[$system][$module][$role_id][$postfix][$action])){
		return false;
	}
	
	$rule = &$this->rules[$system][$module][$role_id][$postfix][$action];
	
	//���»���
	$credit = array();
	//������־
	$log = array();
	//������־
	$rule_log = array();
	//������־����
	$rule_log_cache = array();
	foreach($rule as $k => $v){
		
		if($v['times']){
			//�д�������,�ȴ��ڴ滺�������
			$check = $this->DB_master->fetch_one("SELECT times AS num, timestamp FROM $this->rule_log_cache_table WHERE uid = '$uid' AND rule_id = '$k'");
			
			if(empty($check)){
				//�����û�г�������
				$check = $this->DB_master->fetch_one(
					"SELECT COUNT(*) AS num FROM $this->rule_log_table WHERE uid = '$uid' AND rule_id = '$k'". ($v['interval'] ? ' AND timestamp > '. (P8_TIME - $v['interval']) : '')
				);
			}else{
				//Ƶ�ʹ���,���¼������
				if($v['interval'] && $check['timestamp'] + $v['interval'] < P8_TIME){
					$check['num'] = 0;
				}
			}
			
			//�������ƾ�����
			if($check['num'] >= $v['times']) continue;
			
			$rule_log_cache[] = array($uid, $k, P8_TIME, $check['num'] +1);
		}
		
		$credit[$v['credit_id']] = $v['credit'];
		$log[] = array($uid, $v['credit_id'], $v['credit'], P8_TIME);
		$rule_log[] = array($uid, $k, P8_TIME);
	}
	
	if($this->core->update_credit($uid, $credit)){
		//replace into ��ʽ���뻺���
		$this->DB_master->insert(
			$this->rule_log_cache_table,
			$rule_log_cache,
			array(
				'multiple' => array('uid' ,'rule_id', 'timestamp', 'times'),
				'replace' => true
			)
		);
		
		$this->log($log);
		$this->rule_log($rule_log);
	}
	
	return $credit;
}

/**
* ��ȡ����Ĺ���
**/
function get_cache_rule($system, $module = '', $role_id = 0, $postfix = ''){
	$key = $system;
	$key = $module ? $key .'-'. $module : $key;
	$no_role_key = $key;
	$key = $role_id ? $key .'-role-'. $role_id : $key;
	$key = $postfix ? $key .'#'. $postfix : $key;
	$no_role_key = $postfix ? $no_role_key .'#'. $postfix : $no_role_key;
	
	global $CACHE;
	//�ȼ���ض���ɫ��
	$rule = $CACHE->read('core/modules/credit', 'rule', $key . $this->last_cache);
	if(!empty($rule)){
		$this->rules[$system][$module][$role_id][$postfix] = $rule;
		return true;
	}
	
	//����ض���ɫ��û��,�ټ�鹫�ý�ɫ��
	if($role_id && $rule = $CACHE->read('core/modules/credit', 'rule', $no_role_key . $this->last_cache)){
		if(empty($rule)) return false;
		
		$this->rules[$system][$module][0][$postfix] = $rule;
		$this->rules[$system][$module][$role_id][$postfix] = &$this->rules[$system][$module][0][$postfix];
		//����
	}
}

/**
* ��¼���ֵ�ʧ��־
**/
function log($logs){
	return $this->DB_master->insert(
		$this->log_table,
		$logs,
		array(
			'multiple' => array('uid', 'credit_id', 'credit', 'timestamp')
		)
	);
}

/**
* ��¼���ֹ���Ӧ����־
**/
function rule_log($logs){
	return $this->DB_master->insert(
		$this->rule_log_table,
		$logs,
		array(
			'multiple' => array('uid', 'rule_id', 'timestamp'),
		)
	);
}

/**
* ���ɻ���
**/
function cache(){
	parent::cache();
	
	return include $this->path .'call/cache.call.php';
}

/**
* ��ӹ���
* @param int $credit_id �������͵�ID
* @param string $system ���ֹ������ڵ�ϵͳ
* @param string $module ���ֹ������ڵ�ģ��
* @param string $action ���ֹ������ڵ�action
* @param int|float $credit ���ֹ������÷ֵĻ���
* @param int $times ����Ӧ�õĴ���
* @param int $interval ����Ӧ��Ƶ��,��λΪ��
**/
function add_rule($data){
	return $this->DB_master->insert(
		$this->rule_table,
		$data,
		array('return_id' => true)
	);
}

/**
* �޸Ĺ���,����ͬ���
**/
function update_rule($id, $data){
	return $this->DB_master->update(
		$this->rule_table,
		$data,
		"id = '$id'"
	);
}

/**
* ɾ������
**/
function delete_rule($id){
	return $this->DB_master->delete(
		$this->rule_table,
		"id = '$id'"
	);
}

/**
* ��ID�鿴һ����������
**/
function view($id){
	$ret = $this->DB_master->fetch_one("SELECT * FROM $this->table WHERE id = '$id'");
	$ret['roe'] = mb_unserialize($ret['roe']);
	return $ret;
}

/**
* ��ID�鿴һ�����ֹ���
**/
function view_rule($id){
	return $this->DB_master->fetch_one("SELECT * FROM $this->rule_table WHERE id = '$id'");
}

}