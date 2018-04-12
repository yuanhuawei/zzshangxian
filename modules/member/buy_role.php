<?php
defined('PHP168_PATH') or die();

/**
* 购买角色
**/

if(REQUEST_METHOD == 'GET'){
	
	if(empty($UID)){
		message('not_login', $this_module->U_controller .'-login');
	}
	
	$role_id = isset($_GET['role_id']) ? intval($_GET['role_id']) : 0;
	
	$core->get_cache('role');
	$credit = $core->CONFIG['credits'][$this_module->CONFIG['recharge']['credit_type']]['name'];
	$unit = $core->CONFIG['credits'][$this_module->CONFIG['recharge']['credit_type']]['unit'];
	$config = $this_module->CONFIG['buy_role'];
	
	if(
		$role_id &&
		(!isset($core->roles[$role_id]) ||
		$core->roles[$role_id]['gid'] != $ROLE_GROUP)
	) message('access_denied');
	
	include template($this_module, 'buy_role');
	
}else if(REQUEST_METHOD == 'POST'){
	
	//*****************************************{
	if(isset($_POST['pay_notify'])){
		//支付完成的回调
		$notify = mb_unserialize(p8_code(p8_stripslashes2($_POST['pay_notify']), false));
		if(!isset($notify['timestamp'])) exit('fail');
		
		write_file($this_module->path, 'br.log', var_export($notify, true), 'a');
		
		if(empty($notify['paid'])){
			exit('success');	//未付款的状态码均返回成功,一般为即时到账
		}else{
			
			//还有未过期的角色,如果买相同的当续费,不相同就覆盖
			$check = $DB_master->fetch_one("SELECT * FROM {$this_module->TABLE_}buy_role WHERE uid = '$notify[buyer_uid]' AND status = '1'");
			
			if($check && $check['role_id'] == $notify['role_id']){
				//续费
				$time = $check['expire'];
				
				$DB_master->update(
					$this_module->TABLE_ .'buy_role',
					array(
						'status' => -1
					),
					"order_NO = '$check[order_NO]'"
				);
			}else{
				//重新购买
				$time = P8_TIME;
			}
			
			//支付成功,计算过期时间并修改角色
			list($Y, $m, $d) = explode('|', date('Y|m|d', $time));
			switch($notify['time']){
				case 30: $m += 1; break;
				case 90: $m += 3; break;
				case 180: $m += 6; break;
				case 365: $Y += 1; break;
			}
			$expire = mktime(0, 0, 0, $m, $d, $Y);
			
			if(
				$DB_master->update(
					$this_module->TABLE_ .'buy_role',
					array(
						'status' => 1,
						'expire' => $expire
					),
					"order_NO = '$notify[order_NO]'"
				)
			){
				$DB_master->update(
					$this_module->table,
					array(
						'last_role_id' => 'role_id',
						'role_id' => $notify['role_id']
					),
					false
				);
				
				//删除SESSION
				delete_session("uid = '$notify[buyer_uid]'");
			}
		}
		
		exit('success');
	}
	//*****************************************}
	
	
	
	if(empty($UID)){
		message('not_login', $this_module->U_controller .'-login');
	}
	
	$role_id = isset($_POST['role_id']) ? intval($_POST['role_id']) : 0;
	$time = isset($_POST['time']) ? intval($_POST['time']) : 0;
	$core->get_cache('role');
	
	$config = $this_module->CONFIG['buy_role'];
	//角色不存在或不可购买,或与当前用户角色不在同一角色组
	
	if(
		!isset($core->roles[$role_id]) ||
		empty($config[$role_id][$time]) ||
		$core->roles[$role_id]['gid'] != $ROLE_GROUP
	) message('access_denied');
	
	$name = p8lang($P8LANG['buy_role']['order_name'], $core->roles[$role_id]['name']);
	
	$amount = $config[$role_id][$time];
	
	//调用支付模块生成一个订单
	$pay = &$core->load_module('pay');
	$data = array(
		'name' => $name,
		'amount' => $amount,
		'number' => 1,
		'NO_prefix' => 'MBR',
		'seller_uid' => 0,
		'buyer_uid' => $UID,
		'buyer_username' => $USERNAME,
		'notify' => array(
			'system' => $SYSTEM,
			'module' => $MODULE,
			'action' => $ACTION,
			'role_id' => $role_id,
			'time' => $time,
		)
	);
	$order = $pay->order($data);
	
	//购买记录
	$DB_master->insert(
		$this_module->TABLE_ .'buy_role',
		array(
			'order_NO' => $order['NO'],
			'uid' => $UID,
			'username' => $USERNAME,
			'amount' => $amount,
			'role_id' => $role_id,
			'time' => $time,
			'status' => 0,
			'timestamp' => P8_TIME
		)
	);
	
	//跳转到支付接口
	header('Location: '. $pay->controller .'-pay?'.
		'NO='. $order['NO'] .'&name='. urlencode($order['name']) .'&amount='. $order['amount'] .'&number='. $order['number']. '&seller_uid=0');
}