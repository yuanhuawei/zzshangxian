<?php
defined('PHP168_PATH') or die();

//P8_Member::pay_buy_role($pay, $notify)
	if(empty($notify['paid'])){
		return true;	//δ�����״̬������سɹ�,һ��Ϊ��ʱ����
	}else{
		
		//����δ���ڵĽ�ɫ,�������ͬ�ĵ�����,����ͬ�͸���
		$check = $this->DB_master->fetch_one("SELECT * FROM {$this->TABLE_}buy_role WHERE uid = '$notify[buyer_uid]' AND status = '1'");
		
		if($check && $check['role_id'] == $notify['role_id']){
			//����
			$time = $check['expire'];
			
			$this->DB_master->update(
				$this->TABLE_ .'buy_role',
				array(
					'status' => -1
				),
				"order_NO = '$check[order_NO]'"
			);
		}else{
			//���¹���
			$time = P8_TIME;
		}
		
		//֧���ɹ�,�������ʱ�䲢�޸Ľ�ɫ
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
			
			//ɾ��SESSION
			delete_session("uid = '$notify[buyer_uid]'");
		}
	}