<?php
defined('PHP168_PATH') or die();

//P8_Member::pay_buy_role($pay, $notify)
	if(empty($notify['paid'])){
		return true;	//未付款的状态码均返回成功,一般为即时到账
	}else{
		
		//还有未过期的角色,如果买相同的当续费,不相同就覆盖
		$check = $this->DB_master->fetch_one("SELECT * FROM {$this->TABLE_}buy_role WHERE uid = '$notify[buyer_uid]' AND status = '1'");
		
		if($check && $check['role_id'] == $notify['role_id']){
			//续费
			$time = $check['expire'];
			
			$this->DB_master->update(
				$this->TABLE_ .'buy_role',
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
			$this->DB_master->update(
				$this->TABLE_ .'buy_role',
				array(
					'status' => 1,
					'expire' => $expire
				),
				"order_NO = '$notify[order_NO]'"
			)
		){
			$this->DB_master->update(
				$this->table,
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