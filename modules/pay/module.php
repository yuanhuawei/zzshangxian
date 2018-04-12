<?php
defined('PHP168_PATH') or die();

/**
����״̬��
-1	���׹ر�
0	δ����
1	������
2	������
3	�������
**/

class P8_Pay extends P8_Module{

var $table;						//���ݱ�
var $order_table;				//������
var $log_table;					//��־��
var $interface_table;			//֧����ʽ
var $member_interface_table;	//�û��Լ���֧����ʽ
var $lock_table;
var $STATUS = array(
	'TRADE_CLOSED' => -1,
	'WAIT_BUYER_PAY' => 0,
	'BUYER_PAID' => 1,
	'SELLER_SENT' => 2,
	'TRADE_SUCCESS' => 3
);

function __construct(&$system, $name){
	$this->system = &$system;

	parent::__construct($name);
	
	$this->table = $this->TABLE_;
	$this->order_table = $this->TABLE_ .'order';
	$this->log_table = $this->TABLE_ .'log';
	$this->interface_table = $this->TABLE_ .'interface';
	$this->member_interface_table = $this->TABLE_ .'member_interface';
	$this->lock_table = $this->TABLE_ .'order_lock';
}

function P8_Pay(&$system, $name){
	$this->__construct($system, $name);
}

/**
* ����֧������
* @param string $NO �������
* @param string $interface �ӿ�����
**/
function pay($NO, $interface){
	//ȡ�ö�����Ϣ
	$order = $this->get_order_by_NO($NO);
	if(empty($order)) return null;
	
	require_once $this->path .'interface/'. $interface .'/interface.php';
	$class = 'P8_Pay_'. $interface;
	//�������������δ����,���Ǹ����վ,������Ǹ�����û�
	$config = empty($order['seller_uid']) ? 
		$this->CONFIG['interfaces'][$interface]['config'] :
		$this->interface_config($interface, $order['seller_uid']);
	
	$int = new $class($this, $config, $order);
	
	$ret = $int->pay($order);
	if($ret === null) return null;
	
	//�޸Ķ����Ľӿ�����
	$this->DB_master->update(
		$this->order_table,
		array('interface' => $interface),
		"NO = '$NO'"
	);
	
	return $ret;
}

/**
* ����֧���ӿڵ�֪ͨ
* @param string $interface ֧���ӿ�����
* @param string $NO �������
* @param int $status ����Ա���û��޸ĵĶ���״̬,����֧���ӿ������, ����֧�����з����ӿ�
* @return null|array
**/
function notify($interface, $NO, $status = null, $order = null){
	
	$ret = null;
	if($order === null)
		$order = $this->get_order_by_NO($NO);
	
	if(empty($order)) return true;	//����Ϊ��,��Ҫ�ٽ�����
	
	//���������Ĵ���,ֻ�ܵ��̴߳���
	$tid = $this->DB_master->insert(
		$this->lock_table,
		array('NO' => $order['NO']),
		array('return_id' => true)
	);
	//����ʧ��,�����߳��ڴ���
	if(!$tid){
		return null;
	}
	
	//��������Ѿ�ѡ����֧���ӿ�
	$interface = empty($interface) ? 
		(empty($order['interface']) ? '' : $order['interface']) :
		$interface;
	
	if($interface){
		//����֧���ӿ�
		require_once $this->path .'interface/'. $interface .'/interface.php';
		$class = 'P8_Pay_'. $interface;
		
		$config = empty($order['seller_uid']) ?
			$this->CONFIG['interfaces'][$interface]['config'] :
			$this->interface_config($interface, $order['seller_uid']);
		
		$int = new $class($this, $config, $order);
		
		//�ӿ�֪ͨ
		if(($ret = $int->notify($status)) === null){
			//ɾ������
			$this->DB_master->delete(
				$this->lock_table,
				"id = '$tid'"
			);
			return null;
		}
		
		$status = $ret['status'];
	}else{
		
		$ret = array(
			'status' => $status,
			'amount' => $order['amount'],
			'number' => $order['number']
		);
	}
	
	$ever_paid = $order['status'] == $this->STATUS['TRADE_SUCCESS'] ? 1 : 0;
	$paid = $status == $this->STATUS['TRADE_SUCCESS'] ? 1 : 0;
	
	//����״̬û�з����ı�,�п������ظ��ύ,֧�����
	if($status == $order['status'] || $ever_paid){
		$this->DB_master->delete(
			$this->lock_table,
			"id = '$tid'"
		);
		
		return $ever_paid || $status == $this->STATUS['WAIT_BUYER_PAY'] ? true : null;
	}
	
	//if($order['amount'] !== $ret['amount']) //��֤���
	
	$data = array(
		'status' => $status,
		'paid' => $paid
	);
	if(!empty($ret['interface_NO'])) $data['interface_NO'] = $ret['interface_NO'];
	
	if(
		//���¶���״̬
		$update_status = $this->DB_master->update(
			$this->order_table,
			$data,
			"NO = '$order[NO]'"
		)
	){
		if($paid){
			//������ɺ�֧����¼��־��
			$log = array(
				'order_NO' => $order['NO'],
				'interface' => $interface,
				'payer_uid' => $order['buyer_uid'],
				'payer_username' => $order['buyer_username'],
				'amount' => $order['amount'],
				'timestamp' => P8_TIME
			);
			$this->log($log);
			unset($log);
		}
		
		$order['status'] = $status;
		$order['paid'] = $paid;
		
		
		
		$notify = $order['notify'];
		
		$notify['status'] = $status;
		$notify['order_NO'] = $order['NO'];
		$notify['paid'] = $paid;
		$notify['seller_uid'] = $order['seller_uid'];
		$notify['seller_username'] = $order['seller_username'];
		$notify['buyer_uid'] = $order['buyer_uid'];
		$notify['buyer_username'] = $order['buyer_username'];
		$notify['timestamp'] = P8_TIME;
		
		$info = get_module($notify['system'], $notify['module']);
		if(!empty($info['installed'])){
			if($notify['system'] == 'core'){
				$system = &$this->core;
			}else{
				$system = &$this->core->load_system($notify['system']);
			}
			$module = &$system->load_module($notify['module']);
			
			if(method_exists($module, $notify['method'])){
				$response = $module->$notify['method']($this, $notify);
			}else{
				$ret = null;
			}
		}else{
			$ret = null;
		}
		
		write_file(CACHE_PATH .'log/pay.log.php', '<?php exit;?>$_SERVER:'. var_export($_SERVER, true) .'$_REQUEST:'. var_export($_REQUEST, true) .'notify:'. var_export($notify, true) ."\r\n", 'a'); //for log
	}
	//�������
	
	//ɾ������
	$this->DB_master->delete(
		$this->lock_table,
		"id = '$tid'"
	);
	
	return $ret;
	
}

/**
* �г�֧���ӿ�
* @param bool $refresh �Ƿ�ˢ��
* @return array
**/
function list_interface($refresh = false){
	
	if($refresh){
		
		return require $this->path .'call/list_interface.call.php';
		
	}else{
		return empty($this->CONFIG['interfaces']) ? array() : $this->CONFIG['interfaces'];
	}
}

/**
* ����
**/
function cache(){
	//ˢ��֧���ӿ�
	$this->list_interface(true);
}

/**
* ���֧���ӿ��Ƿ����,����֧���ӿڿ���
* @param string $interface �ӿ�����
* @return bool
**/
function check_interface($interface){
	return !empty($this->CONFIG['interfaces'][$interface]['enabled']);
}

/**
* ���ýӿ�/��ȡ�ӿ�����
* @param string $interface �ӿ�����
* @param int $seller_uid ����ID,�����������������վ������
* @param array $config �ӿ�����,���Ϊ����Ϊȡ�ýӿ�����
**/
function interface_config($interface, $seller_uid = 0, $config = array()){
	
	if(empty($config)){
		
		if(empty($seller_uid)){
			$tmp = $this->DB_master->fetch_one("SELECT config FROM $this->interface_table WHERE name = '$interface'");
		}else{
			$tmp = $this->DB_master->fetch_one("SELECT config FROM $this->member_interface_table WHERE uid = '$seller_uid' AND name = '$interface'");
		}
		
		if(empty($tmp)) return array();
		
		return mb_unserialize($tmp['config']);
		
	}else{
		
		if(empty($seller_uid)){
			//������վ��֧���ӿ�
			$this->DB_master->update(
				$this->interface_table,
				array(
					'config' => $this->DB_master->escape_string(serialize($config))
				),
				"name = '$interface'"
			);
			$this->list_interface(true);
			
		}else{
			//replace into, �����û���֧���ӿ�
			$this->DB_master->insert(
				$this->member_interface_table,
				array(
					'uid' => $seller_uid,
					'name' => $interface,
					'config' => $this->DB_master->escape_string(serialize($config))
				),
				array(
					'replace' => true
				)
			);
		}
		
		return true;
	}
}

/**
* ����/�رսӿ�
* @param string $interface �ӿ�����
* @param bool $enabled ����
**/
function enable_interface($interface, $enabled = true){
	$this->DB_master->update(
		$this->interface_table,
		array(
			'enabled' => $enabled ? 1 : 0
		),
		"name = '$interface'"
	);
	
	$this->list_interface(true);
	return true;
}

/**
* �¶���,$dataһ��Ҫ���˺��ٴ�����
* @param array $data ��������
* @return array ������Ϣ
**/
function order(&$data){
	$db_data = array();
	
	$db_data['name'] = isset($data['name']) ? $data['name'] : '';
	$db_data['amount'] = isset($data['amount']) ? floatval($data['amount']) : 0;
	$db_data['number'] = isset($data['number']) ? intval($data['number']) : 1;
	//$data['interface'] = isset($data['interface']) && $this->check_interface($data['interface']) ? $data['interface'] : '';
	$db_data['notify'] = isset($data['notify']) ? (array) $data['notify'] : array();
	$db_data['notify'] = $this->DB_master->escape_string(serialize($data['notify']));
	//�������ǰ׺
	$NO_prefix = empty($data['NO_prefix']) ? '' : $data['NO_prefix'];
	$db_data['buyer_uid'] = $data['buyer_uid'];
	$db_data['buyer_username'] = $data['buyer_username'];
	$db_data['seller_uid'] = isset($data['seller_uid']) ? intval($data['seller_uid']) : 0;
	$db_data['seller_username'] = isset($data['seller_username']) ? intval($data['seller_username']) : '';
	$db_data['ip'] = P8_IP;
	$db_data['timestamp'] = P8_TIME;
	
	$id = 0;
	do{
		//��ֹ���к��ظ�,�嵽���ظ�Ϊֹ,NO�ֶ��Ѿ�����unique����
		$db_data['NO'] = $NO_prefix . date('YmdHi', P8_TIME) . mt_rand(10, 99);
		
		$id = $this->DB_master->insert(
			$this->order_table,
			$db_data,
			array('return_id' => true)
		);
		
	}while(!$id);
	
	return $db_data;
}

/**
* ��������Ż�ȡ����
**/
function get_order_by_NO($NO){
	$ret = $this->DB_master->fetch_one("SELECT * FROM $this->order_table WHERE NO = '$NO'");
	$ret['notify'] = mb_unserialize($ret['notify']);
	return $ret;
}

/**
* �޸Ķ�������Ϣ
* @param string $NO �������
* @param array $data Ҫ�޸Ķ�������Ϣ,hashmap
* @return bool
**/
function update_order($NO, $data){
	return $this->DB_master->update(
		$this->order_table,
		$data,
		"NO = '$NO'"
	);
}

/**
* �޸Ķ���״̬
* @param string $NO �������
* @param int $status ����״̬
**/
function update_order_status($NO, $status){
	$order = $this->get_order_by_NO($NO);
	if(empty($order)) return null;
	
	$ret = $this->notify($order['interface'], $NO, $status, $order);
	//write_file($this->path .'uo.log', var_export($ret, true)."\r\n", 'a');
	return $ret;
}

/**
* ֧����־,ֻ��¼��֧���ӿڴ�������
**/
function log(&$data){
	
	return $this->DB_master->insert(
		$this->log_table,
		$data
	);
}

//����ɾ��
function hook_delete(&$obj, $cond){
	
	//ɾ�������û�����Ϊ��ҵĶ���,ֻɾ��ϵͳ����, memberģ�鴫������������ buyer_uid IN ($uid)
	$this->DB_master->delete(
		$this->order_table,
		str_replace('#module_table#', $this->order_table, $cond) ." AND {$this->order_table}.seller_uid = '0'"
	);
	
	//ɾ����Ա��ص�֧���ӿ�����
	$this->DB_master->delete(
		$this->member_interface_table,
		str_replace('buyer_uid', 'uid', str_replace('#module_table#', $this->member_interface_table, $cond))
	);
}

}