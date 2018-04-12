<?php
defined('PHP168_PATH') or die();

/**
交易状态码
-1	交易关闭
0	未付款
1	己付款
2	己发货
3	交易完成
**/

class P8_Pay extends P8_Module{

var $table;						//数据表
var $order_table;				//订单表
var $log_table;					//日志表
var $interface_table;			//支付方式
var $member_interface_table;	//用户自己的支付方式
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
* 生成支付数据
* @param string $NO 订单编号
* @param string $interface 接口名称
**/
function pay($NO, $interface){
	//取得订单信息
	$order = $this->get_order_by_NO($NO);
	if(empty($order)) return null;
	
	require_once $this->path .'interface/'. $interface .'/interface.php';
	$class = 'P8_Pay_'. $interface;
	//如果订单中卖家未定义,则是付款到网站,否则就是付款给用户
	$config = empty($order['seller_uid']) ? 
		$this->CONFIG['interfaces'][$interface]['config'] :
		$this->interface_config($interface, $order['seller_uid']);
	
	$int = new $class($this, $config, $order);
	
	$ret = $int->pay($order);
	if($ret === null) return null;
	
	//修改订单的接口类型
	$this->DB_master->update(
		$this->order_table,
		array('interface' => $interface),
		"NO = '$NO'"
	);
	
	return $ret;
}

/**
* 处理支付接口的通知
* @param string $interface 支付接口名称
* @param string $NO 订单编号
* @param int $status 管理员或用户修改的订单状态,不是支付接口请求的, 比如支付宝有发货接口
* @return null|array
**/
function notify($interface, $NO, $status = null, $order = null){
	
	$ret = null;
	if($order === null)
		$order = $this->get_order_by_NO($NO);
	
	if(empty($order)) return true;	//订单为空,不要再接收了
	
	//锁定订单的处理,只能单线程处理
	$tid = $this->DB_master->insert(
		$this->lock_table,
		array('NO' => $order['NO']),
		array('return_id' => true)
	);
	//插入失败,即有线程在处理
	if(!$tid){
		return null;
	}
	
	//如果订单已经选择了支付接口
	$interface = empty($interface) ? 
		(empty($order['interface']) ? '' : $order['interface']) :
		$interface;
	
	if($interface){
		//调用支付接口
		require_once $this->path .'interface/'. $interface .'/interface.php';
		$class = 'P8_Pay_'. $interface;
		
		$config = empty($order['seller_uid']) ?
			$this->CONFIG['interfaces'][$interface]['config'] :
			$this->interface_config($interface, $order['seller_uid']);
		
		$int = new $class($this, $config, $order);
		
		//接口通知
		if(($ret = $int->notify($status)) === null){
			//删除锁定
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
	
	//订单状态没有发生改变,有可能是重复提交,支付完成
	if($status == $order['status'] || $ever_paid){
		$this->DB_master->delete(
			$this->lock_table,
			"id = '$tid'"
		);
		
		return $ever_paid || $status == $this->STATUS['WAIT_BUYER_PAY'] ? true : null;
	}
	
	//if($order['amount'] !== $ret['amount']) //验证金额
	
	$data = array(
		'status' => $status,
		'paid' => $paid
	);
	if(!empty($ret['interface_NO'])) $data['interface_NO'] = $ret['interface_NO'];
	
	if(
		//更新订单状态
		$update_status = $this->DB_master->update(
			$this->order_table,
			$data,
			"NO = '$order[NO]'"
		)
	){
		if($paid){
			//交易完成后将支付记录日志表
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
	//事务结束
	
	//删除锁定
	$this->DB_master->delete(
		$this->lock_table,
		"id = '$tid'"
	);
	
	return $ret;
	
}

/**
* 列出支付接口
* @param bool $refresh 是否刷新
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
* 缓存
**/
function cache(){
	//刷新支付接口
	$this->list_interface(true);
}

/**
* 检查支付接口是否存在,并且支付接口可用
* @param string $interface 接口名称
* @return bool
**/
function check_interface($interface){
	return !empty($this->CONFIG['interfaces'][$interface]['enabled']);
}

/**
* 设置接口/获取接口设置
* @param string $interface 接口名称
* @param int $seller_uid 卖家ID,如果不设置则是设网站的配置
* @param array $config 接口配置,如果为空则为取得接口配置
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
			//配置网站的支付接口
			$this->DB_master->update(
				$this->interface_table,
				array(
					'config' => $this->DB_master->escape_string(serialize($config))
				),
				"name = '$interface'"
			);
			$this->list_interface(true);
			
		}else{
			//replace into, 配置用户的支付接口
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
* 开启/关闭接口
* @param string $interface 接口名称
* @param bool $enabled 开关
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
* 下订单,$data一定要过滤好再传进来
* @param array $data 订单数据
* @return array 订单信息
**/
function order(&$data){
	$db_data = array();
	
	$db_data['name'] = isset($data['name']) ? $data['name'] : '';
	$db_data['amount'] = isset($data['amount']) ? floatval($data['amount']) : 0;
	$db_data['number'] = isset($data['number']) ? intval($data['number']) : 1;
	//$data['interface'] = isset($data['interface']) && $this->check_interface($data['interface']) ? $data['interface'] : '';
	$db_data['notify'] = isset($data['notify']) ? (array) $data['notify'] : array();
	$db_data['notify'] = $this->DB_master->escape_string(serialize($data['notify']));
	//订单序号前缀
	$NO_prefix = empty($data['NO_prefix']) ? '' : $data['NO_prefix'];
	$db_data['buyer_uid'] = $data['buyer_uid'];
	$db_data['buyer_username'] = $data['buyer_username'];
	$db_data['seller_uid'] = isset($data['seller_uid']) ? intval($data['seller_uid']) : 0;
	$db_data['seller_username'] = isset($data['seller_username']) ? intval($data['seller_username']) : '';
	$db_data['ip'] = P8_IP;
	$db_data['timestamp'] = P8_TIME;
	
	$id = 0;
	do{
		//防止序列号重复,插到不重复为止,NO字段已经作了unique索引
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
* 按订单编号获取订单
**/
function get_order_by_NO($NO){
	$ret = $this->DB_master->fetch_one("SELECT * FROM $this->order_table WHERE NO = '$NO'");
	$ret['notify'] = mb_unserialize($ret['notify']);
	return $ret;
}

/**
* 修改订单的信息
* @param string $NO 订单编号
* @param array $data 要修改订单的信息,hashmap
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
* 修改订单状态
* @param string $NO 订单编号
* @param int $status 订单状态
**/
function update_order_status($NO, $status){
	$order = $this->get_order_by_NO($NO);
	if(empty($order)) return null;
	
	$ret = $this->notify($order['interface'], $NO, $status, $order);
	//write_file($this->path .'uo.log', var_export($ret, true)."\r\n", 'a');
	return $ret;
}

/**
* 支付日志,只记录从支付接口传回来的
**/
function log(&$data){
	
	return $this->DB_master->insert(
		$this->log_table,
		$data
	);
}

//关联删除
function hook_delete(&$obj, $cond){
	
	//删除关联用户的作为买家的订单,只删除系统订单, member模块传过来的条件是 buyer_uid IN ($uid)
	$this->DB_master->delete(
		$this->order_table,
		str_replace('#module_table#', $this->order_table, $cond) ." AND {$this->order_table}.seller_uid = '0'"
	);
	
	//删除会员相关的支付接口设置
	$this->DB_master->delete(
		$this->member_interface_table,
		str_replace('buyer_uid', 'uid', str_replace('#module_table#', $this->member_interface_table, $cond))
	);
}

}